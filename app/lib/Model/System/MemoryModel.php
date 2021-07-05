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
 * @version    0.1.11
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\System;

/** 
 * MemoryModel
 */
class MemoryModel extends SystemModel
{
    public static function getMemory()
    {
        // free
        $free = 0;
        if (shell_exec('cat /proc/meminfo')){
            $free    = shell_exec('grep MemFree /proc/meminfo | awk \'{print $2}\'');
            $buffers = shell_exec('grep Buffers /proc/meminfo | awk \'{print $2}\'');
            $cached  = shell_exec('grep Cached /proc/meminfo | awk \'{print $2}\'');
            $free = (int)$free + (int)$buffers + (int)$cached;
        }

        // total
        if (!($total = shell_exec('grep MemTotal /proc/meminfo | awk \'{print $2}\''))){
            $total = 0;
        }
        $total = self::getNumeric($total);
        $free = self::getNumeric($free);
        
        // Used
        
        $used = $total - $free;

        // Percent used/free
        $percentUsed = ($total > 0 ) ? 100 - (round($free / $total * 100)) : 0 ;
        $percentFree = 100 - $percentUsed;

        return array(
            'used'          => self::getSize($used * 1024),
            'free'          => self::getSize($free * 1024),
            'total'         => self::getSize($total * 1024),
            'percentUsed'   => $percentUsed,
            'percentFree'   => $percentFree,
            'alertCode'     => self::getAlertCode($percentUsed),
        );
    } 

    public static function getSwap()
    {
        // Free
        if (!(int)$free = self::getNumeric(shell_exec('grep SwapFree /proc/meminfo | awk \'{print $2}\''))){
            $free = 0;
        }

        // Total
        if (!(int)$total = self::getNumeric(shell_exec('grep SwapTotal /proc/meminfo | awk \'{print $2}\''))){
            $total = 0;
        }

        // Used
        $used = $total - $free;

        // Percent used/free
        $percentUsed = ($total > 0 ) ? 100 - (round($free / $total * 100)) : 0 ;
        $percentFree = 100 - $percentUsed;
        
        return array(
            'used'         => self::getSize($used * 1024),
            'free'         => self::getSize($free * 1024),
            'total'        => self::getSize($total * 1024),
            'percentUsed'  => $percentUsed,
            'percentFree'  => $percentFree,
            'alertCode'    => self::getAlertCode($percentUsed),
        );
    }
}