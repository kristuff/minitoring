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
 * @version    0.1.1
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\System;

use Kristuff\Minitoring\Model\System\SystemModel;

/** 
 * SystemctlModel
 */
class SystemctlModel extends SystemModel
{
    /**
     * Get service status
     * 
     * ● fail2ban.service - Fail2Ban Service
     *    Loaded: loaded (/lib/systemd/system/fail2ban.service; enabled; vendor preset: enabled)
     *    Active: active (running) since Fri 2020-09-25 20:24:50 CEST; 34min ago
     *      Docs: man:fail2ban(1)
     *   Process: 526 ExecStartPre=/bin/mkdir -p /var/run/fail2ban (code=exited, status=0/SUCCESS)
     *  Main PID: 536 (fail2ban-server)
     *     Tasks: 27 (limit: 4676)
     *    Memory: 42.8M 
     *    CGroup: /system.slice/fail2ban.service
     *            └─536 /usr/bin/python3 /usr/bin/fail2ban-server -xf start
     * 
     * @access public
     * @static
     * @param string    $jail       The jail name
     *
     * @return array    
     */
    public static function getStatus(string $service): array
    {
        $status = [];
        $searchIndex = 0;
        $patterns = [
            'description'       => "#.*$service.service \- (?P<description>.*)#",
            'status'            => "#.*Active: (?P<status>(active|inactive) #",
            'fileList'          => "#.*File list:\s+(?P<fileList>.*)#",
            'currentlyBanned'   => "#.*Currently banned:\s+(?P<currentlyBanned>[\d]+)#",
            'totalBanned'       => "#.*Total banned:\s+(?P<totalBanned>[\d]+)#",
            'bannedIpList'      => "#.*Banned IP list:\s+(?P<bannedIpList>[\d\s\.:]+)#",
        ];

        exec("systemctl status " . $service . '.service', $out);

        foreach ($out as $row) {

            for ($i=$searchIndex; $i<count($patterns); $i++) {

                $key = array_keys($patterns)[$i];
                if (preg_match($patterns[$key], $row, $output)) {
                    switch($key){
                        case 'fileList':
                        case 'bannedIpList':
                            $status[$key] = explode(' ', trim($output[$key]));
                            break;
                        default:
                            // integer
                            $status[$key] = intval(trim($output[$key]));
                    }
                    $searchIndex++;

                }
            }
        }
        return $status;
    }

}