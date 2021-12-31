<?php

/** 
 *        _      _ _           _
 *  _ __ (_)_ _ (_) |_ ___ _ _(_)_ _  __ _
 * | '  \| | ' \| |  _/ _ \ '_| | ' \/ _` |
 * |_|_|_|_|_||_|_|\__\___/_| |_|_||_\__, |
 *                                   |___/
 * 
 * This file is part of Kristuff\Minitoring.
 * (c) Kristuff <kristuff@kristuff.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version    0.1.21
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\System;

use Kristuff\Minitoring\Model\System\SystemModel;

/** 
 * CpuModel
 */
class CpuModel extends SystemModel
{
    /** 
     * 
     *
     * @access public
     * @static 
     *
     * @return array
     */
    public static function getInfos(bool $showCpuTemp = false)
    {
        // Number of cores
        $numCores = self::getCpuCoresNumber();

        // CPU info
        $model      = 'N.A';
        $frequency  = 'N.A';
        $cache      = 'N.A';
        $bogomips   = 'N.A';
        $temp       = 'N.A';

        if ($cpuinfo = shell_exec('cat /proc/cpuinfo')){
            $processors = preg_split('/\s?\n\s?\n/', trim($cpuinfo));

            foreach ($processors as $processor){
                $details = preg_split('/\n/', $processor, -1, PREG_SPLIT_NO_EMPTY);

                foreach ($details as $detail){
                    list($key, $value) = preg_split('/\s*:\s*/', trim($detail));

                    switch (strtolower($key)){
                        case 'model name':
                        case 'cpu model':
                        case 'cpu':
                        case 'processor':
                            $model = $value;
                            break;

                        case 'cpu mhz':
                        case 'clock':
                            $frequency = $value.' MHz';
                            break;

                        case 'cache size':
                        case 'l2 cache':
                            $cache = $value;
                            break;

                        case 'bogomips':
                            $bogomips = $value;
                            break;
                    }
                }
            }
        }

        if ($frequency == 'N.A'){
            if ($f = shell_exec('cat /sys/devices/system/cpu/cpu0/cpufreq/cpuinfo_max_freq')){
                $f = $f / 1000;
                $frequency = $f.' MHz';
            }
        }

        // CPU Temp
        if ($showCpuTemp){
            $temp = self::getCpuTemperature();
        }

        return array(
            'model'       => $model,
            'cores'       => $numCores,
            'frequency'   => $frequency,
            'cache'       => $cache,
            'bogomips'    => $bogomips,
            'temperature' => $temp,
        );
    }

    /** 
     * 
     *
     * @access private
     * @static
     *
     * @return string
     */
    private static function getCpuTemperature()
    {
        if (@exec('/usr/bin/sensors | grep -E "^(CPU Temp|Core 0)" | cut -d \'+\' -f2 | cut -d \'.\' -f1', $t)){
            if (isset($t[0])){
                return  $t[0].' °C';
            }
        }
        if (@exec('cat /sys/class/thermal/thermal_zone0/temp', $t)){
            return round($t[0] / 1000).' °C';
        }
        return 'N.A';
    }

    /** 
     * 
     *
     * @access public
     * @static
     *
     * @return array
     */
    public static function getLoadAverage()
    {
        if (!($loadTmp = shell_exec('cat /proc/loadavg | awk \'{print $1","$2","$3}\''))){
            return array(0, 0, 0);
        }

        // Number of cores
        $cores = self::getCpuCoresNumber();
        $loadExp = explode(',', $loadTmp);

       
        $load = array_map(
            function ($value, $cores) {
                $v = (int)((float)$value * 100 / $cores);
                if ($v > 100)
                    $v = 100;
                return $v;
            }, 
            $loadExp,
            array_fill(0, 3, $cores)
        );
        return [
            'load1'           => trim($loadExp[0]),
            'load1purcent'    => $load[0],
            'load1AlertCode'  => self::getAlertCode($load[0]),
            'load5'           => trim($loadExp[1]),
            'load5purcent'    => $load[1],
            'load5AlertCode'  => self::getAlertCode($load[1]),
            'load15'          => trim($loadExp[2]),
            'load15purcent'   => $load[2],
            'load15AlertCode' => self::getAlertCode($load[2]),
        ];
    }
}