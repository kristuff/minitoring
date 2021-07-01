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
 * @version    0.1.10
 * @copyright  2017-2021 Kristuff
 */
namespace Kristuff\Minitoring\Model\System;

use Kristuff\Minitoring\Model\System\SystemBaseModel;

/** 
 * SystemModel
 */
class SystemModel extends SystemBaseModel
{
    /** 
     * 
     *
     * @access public
     * @static
     *
     * @return array
     */
    public static function getInfos()
    {
        $uptime = self::getUptime();
        return array(
            'hostname'              => self::getHostname(),
            'os'                    => self::getOperatingSystem(),
       //   'cpunumber'             => self::getCpuCoresNumber(),
       //   'phpversion'            => phpversion(),
            'kernel'                => self::getKernel(),
            'uptime'                => $uptime['uptimePretty'],
            'uptimeDays'            => $uptime['uptimeDays'],
            'lastBoot'              => $uptime['lastBoot'],
         // 'currentUsersNumber'    => self::getCurrentUsersNumber(),
            'serverDate'            => self::getServerDate(),
            'rebootRequired'        => self::isRebootRequired(),
        );
    }

    /** 
     * 
     *
     * @access public
     * @static
     *
     * @return array
     */
    public static function getUptime()
    {
        $uptime = self::getUptimeSeconds();
        return array(
            'uptimePretty'          => self::getHumanTime($uptime),
            'uptimeSeconds'         => $uptime,
            'uptimeDays'            => self::splitTime($uptime)['day'],
            'lastBoot'              => self::getLastBoot(),
            'serverDate'            => self::getServerDate(),
            'rebootRequired'        => self::isRebootRequired(),
        );
    }

    /** 
     * 
     *
     * @access public
     * @static
     *
     * @return bool
     */
    public static function isRebootRequired()
    {
        // debian/unbutu
        return file_exists('/var/run/reboot-required');
    }

    /**
     * Returns hostname
     *
     * @access public
     * @static
     *
     * @return string
     */
    public static function getHostname()
    {
        return php_uname('n');
    }

    /**
     * Returns the OS infos
     *
     * 
     * 'a': This is the default. Contains all modes in the sequence "s n r v m".
     * 's': Operating system name. eg. FreeBSD.
     * 'n': Host name. eg. localhost.example.com.
     * 'r': Release name. eg. 5.1.2-RELEASE.
     * 'v': Version information. Varies a lot between operating systems.
     * 'm': Machine type. eg. i386.

     * @access public
     * @static
     *
     * @return string
     */
    public static function getOs()
    {
        return [
            'full'      => php_uname(),
            'system'    => php_uname('s'),
            'hostname'  => php_uname('n'),
            'release'   => php_uname('r'),
            'version'   => php_uname('v'),
            'arch'      => php_uname('m'),
            'pretty'    => self::getOperatingSystem()
        ];
        
    }
   
    /**
     * Returns Kernel
     *
     * @access public
     * @static
     *
     * @return string
     */
    public static function getKernel()
    {
        if (!($kernel = shell_exec('/bin/uname -r'))){
            $kernel = 'N.A';
        }
        return str_replace("\n", '', $kernel);
    }

    /**
     * 
     * 
     * @access public
     * @static
     *
     * @return string
     */
    public static function getUptimeSeconds()
    {
        if (!($totalSeconds = shell_exec('/usr/bin/cut -d. -f1 /proc/uptime'))){
            return 'N.A';
        }
        return $totalSeconds;
    }

    /**
     * 
     * 
     * @access public
     * @static
     *
     * @return string
     */
    public static function getLastBoot()
    {
        if (!($upt_tmp = shell_exec('cat /proc/uptime'))){   
            return 'N.A';
        }
        $upt = explode(' ', $upt_tmp);
        return date('Y-m-d H:i:s', time() - intval($upt[0]));
    }

    /**
     * 
     * 
     * @access public
     * @static
     *
     * @return string
     */
    public static function getServerDate()
    {
        if (!($serverDate = shell_exec('/bin/date'))){
            return date('Y-m-d H:i:s');
        }
        return str_replace("\n", '', $serverDate);
    }

    /**
     * 
     * 
     * @access public
     * @static
     *
     * @return string
     */
    public static function getOperatingSystem()
    {
        if (!($os = shell_exec('/usr/bin/lsb_release -ds | cut -d= -f2 | tr -d \'"\''))){
            if (!($os = shell_exec('cat /etc/system-release | cut -d= -f2 | tr -d \'"\''))){
                if (!($os = shell_exec('cat /etc/os-release | grep PRETTY_NAME | tail -n 1 | cut -d= -f2 | tr -d \'"\''))){
                    if (!($os = shell_exec('find /etc/*-release -type f -exec cat {} \; | grep PRETTY_NAME | tail -n 1 | cut -d= -f2 | tr -d \'"\''))){
                        $os = 'N.A';
                    }
                }
            }
        }
        $os = trim($os, '"');
        return str_replace("\n", '', $os);
    }


    /**
     * Returns CPU cores number
     * 
     * @access public
     * @static
     *
     * @return int      Number of cores
     */
    public static function getCpuCoresNumber()
    {
        if (!($nbCores = shell_exec('/bin/grep -c ^processor /proc/cpuinfo'))){
            if (!($nbCores = trim(shell_exec('/usr/bin/nproc')))){
                $nbCores = 1;
            }
        }
        return (int)$nbCores > 0 ? (int)$nbCores : 1;
    }

}