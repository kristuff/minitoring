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
 * @version    0.1.15
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\System;

use Kristuff\Miniweb\Mvc\Data\DatabaseModel;
use Kristuff\Minitoring\Model\System\SystemModel;
use Kristuff\Miniweb\Auth\Model\AppSettingsModel;

/** 
 * DiskModel
 */
class DiskModel extends SystemModel
{
    /** 
     * Get disks infos
     *
     * @access public
     * @static
     * @param bool  $showTmpfs          true to displays tmpfs disks, default is false
     * @param bool  $showFileSystem     
     * 
     * @return array
     */
    public static function getInfos(bool $showTmpfs = false, bool $showLoop = false, bool $showFileSystem = true)
    {
        // collected data
        $datas = [];
        $datas['disks'] = []; 
        $datas['totalBytes'] = 0; 
        $datas['totalFreeBytes'] = 0; 
        $datas['totalUsedBytes'] = 0; 
        $datas['totalPercentUsed'] = 0; 
        $datas['totalPercentFree'] = 0; 

        // 
        if (!(exec('/bin/df -T -P | awk -v c=`/bin/df -T | grep -bo "Type" | awk -F: \'{print $2}\'` \'{print substr($0,c);}\' | tail -n +2 | awk \'{print $1","$2","$3","$4","$5","$6","$7}\'', $df))){
           return $datas;
        } 

        $mountedPoints = array();
        $key = 0;

        foreach ($df as $mounted){
            list($filesystem, $type, $total, $used, $free, $percent, $mount) = explode(',', $mounted);

            // tmpfs
            if (strpos($type, 'tmpfs') !== false && $showTmpfs != true){
                continue;
            }

            // loop
            if (strpos($filesystem, '/dev/loop') !== false && $showLoop != true){
                continue;
            }
            
            if (!in_array($mount, $mountedPoints)){
                $mountedPoints[] = trim($mount);

                // total
                $datas['totalBytes'] += $total * 1024; 
                $datas['totalFreeBytes'] += $free * 1024; 
                $datas['totalUsedBytes'] += $used * 1024; 
     
                // Percent used/free
                $percentUsed = (int) trim($percent, '%');
                $percentFree = 100 - $percentUsed;

                // disks info
                $datas['disks'][$key] = array(
                    'type'          => $type,
                    'mount'         => $mount,
                    'total'         => self::getSize($total * 1024),
                    'used'          => self::getSize($used  * 1024),
                    'free'          => self::getSize($free  * 1024),
                    'percentUsed'   => $percentUsed,
                    'percentFree'   => $percentFree,
                    'alertCode'     => self::getAlertCode($percentUsed),
                );

                // filesystem
                if ($showFileSystem){
                    $datas['disks'][$key]['filesystem'] = $filesystem;
                }
            }

            $key++;
        }

         // global datas
        $datas['totalPercentUsed'] = (int) round(($datas['totalUsedBytes'] / $datas['totalBytes']) * 100);
        $datas['totalPercentFree'] = 100 - $datas['totalPercentUsed']; 
        $datas['total']            = self::getSize($datas['totalBytes']);
        $datas['totalFree']        = self::getSize($datas['totalFreeBytes']);
        $datas['totalUsed']        = self::getSize($datas['totalUsedBytes']);
        $datas['alertCode']        = self::getAlertCode($datas['totalPercentUsed']);

        return $datas;
    }

     /** 
     * Get disks infos
     *
     * @access public
     * @static
     * @param bool  $showTmpfs          true to displays tmpfs disks, default is false
     * @param bool  $showFileSystem     
     * 
     * @return array
     */
    public static function getInodesInfos(bool $showTmpfs = false, bool $showLoop = false, bool $showFileSystem = true)
    {
        // collected data
        $datas = [];
        $datas['inodes'] = []; 
        $datas['totalBytes'] = 0; 
        $datas['totalFreeBytes'] = 0; 
        $datas['totalUsedBytes'] = 0; 
        $datas['totalPercentUsed'] = 0; 
        $datas['totalPercentFree'] = 0; 

        // 
        if (!(exec('/bin/df -i -T -P | awk -v c=`/bin/df -T | grep -bo "Type" | awk -F: \'{print $2}\'` \'{print substr($0,c);}\' | tail -n +2 | awk \'{print $1","$2","$3","$4","$5","$6","$7}\'', $df))){
           return $datas;
        } 

        $mountedPoints = array();
        $key = 0;

        foreach ($df as $mounted){
            list($filesystem, $type, $total, $used, $free, $percent, $mount) = explode(',', $mounted);

            // tmpfs
            if (strpos($type, 'tmpfs') !== false && $showTmpfs != true){
                continue;
            }

            // loop
            if (strpos($filesystem, '/dev/loop') !== false && $showLoop != true){
                continue;
            }
            
            if (!in_array($mount, $mountedPoints)){
                $mountedPoints[] = trim($mount);

                // total
                $datas['totalBytes'] += $total * 1024; 
                $datas['totalFreeBytes'] += $free * 1024; 
                $datas['totalUsedBytes'] += $used * 1024; 
     
                // Percent used/free
                $percentUsed = (int) trim($percent, '%');
                $percentFree = 100 - $percentUsed;

                // disks info
                $datas['inodes'][$key] = array(
                    'type'          => $type,
                    'mount'         => $mount,
                    'total'         => self::getSize($total * 1024),
                    'used'          => self::getSize($used  * 1024),
                    'free'          => self::getSize($free  * 1024),
                    'percentUsed'   => $percentUsed,
                    'percentFree'   => $percentFree,
                    'alertCode'     => self::getAlertCode($percentUsed),
                );

                // filesystem
                if ($showFileSystem){
                    $datas['inodes'][$key]['filesystem'] = $filesystem;
                }
            }

            $key++;
        }

         // global datas
        $datas['totalPercentUsed'] = (int) round(($datas['totalUsedBytes'] / $datas['totalBytes']) * 100);
        $datas['totalPercentFree'] = 100 - $datas['totalPercentUsed']; 
        $datas['total']            = self::getSize($datas['totalBytes']);
        $datas['totalFree']        = self::getSize($datas['totalFreeBytes']);
        $datas['totalUsed']        = self::getSize($datas['totalUsedBytes']);
        $datas['alertCode']        = self::getAlertCode($datas['totalPercentUsed']);

        return $datas;
    }
}