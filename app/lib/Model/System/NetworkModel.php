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
 * @version    0.1.7
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\System;

/** 
 * NetworkModel
 */
class NetworkModel extends SystemBaseModel
{
    /**
     * @access private
     * @static
     * @var array $commands     Possible commands for ifconfig and ip
     */
    private static $commands = array(
        'ifconfig' => array('ifconfig', '/sbin/ifconfig', '/usr/bin/ifconfig', '/usr/sbin/ifconfig'),
        'ip'       => array('ip', '/bin/ip', '/sbin/ip', '/usr/bin/ip', '/usr/sbin/ip'),
    );

    /**
     * Returns command line for retreive interfaces
     * 
     * @access protected
     * @static
     * @param array     $commands     Possible commands for ifconfig and ip
     * 
     * @return string|null
     */
    protected static function getInterfacesCommand(array $commands): ?string
    {
        $ifconfig = self::whichCommand($commands['ifconfig'], ' | awk -F \'[/  |: ]\' \'{print $1}\' | sed -e \'/^$/d\'');

        if (!empty($ifconfig)) {
            return $ifconfig;
        }
        
        $ip_cmd = self::whichCommand(self::$commands['ip'], ' -V', false);

        if (!empty($ip_cmd)) {
            return $ip_cmd.' -oneline link show | awk \'{print $2}\' | sed "s/://"';
        }
        
        return null;
    }

    /**
     * Returns command line for retreive IP address from interface name
     * 
     * @access protected
     * @static
     * @param array     $commands       Possible commands for ifconfig and ip
     * @param mixed     $interface      
     * 
     * @return string|null
     */
    protected static function getIpCommand(array $commands, $interface): ?string
    {
        $ifconfig = self::whichCommand($commands['ifconfig'], ' '.$interface.' | awk \'/inet / {print $2}\' | cut -d \':\' -f2');

        if (!empty($ifconfig)) {
            return $ifconfig;
        }
        
        $ip_cmd = self::whichCommand($commands['ip'], ' -V', false);

        if (!empty($ip_cmd)) {
            return 'for family in inet inet6; do '.
                    $ip_cmd.' -oneline -family $family addr show '.$interface.' | grep -v fe80 | awk \'{print $4}\' | sed "s/\/.*//"; ' .
                    'done';
        }

        return null;
    }

    /**
     * Get network informations
     * 
     * @access public
     * @static
     * 
     * @return array
     */
    public static function getNeworkInfos(): array
    {   

        $data               = [];
        $data['network']    = []; 
        $network            = [];
        $getInterfaces_cmd  = self::getInterfacesCommand(self::$commands);

        if (is_null($getInterfaces_cmd) || !(exec($getInterfaces_cmd, $getInterfaces))){
            return array('interface' => 'N.A', 'ip' => 'N.A');
        }

        foreach ($getInterfaces as $name) {
            $ip = null;
            $getIp_cmd = self::getIpCommand(self::$commands, $name);        

            if (is_null($getIp_cmd) || !(exec($getIp_cmd, $ip))) {
                $network[] = array(
                    'name' => $name,
                    'ip'   => 'N.A',
                );
            } else {
                if (!isset($ip[0])){
                    $ip[0] = '';
                }

                $network[] = array(
                    'name' => $name,
                    'ip'   => $ip[0],
                );
            }
        }

        foreach ($network as $interface) {
            // Get transmit and receive datas by interface
            exec('cat /sys/class/net/'.$interface['name'].'/statistics/tx_bytes', $getBandwidth_tx);
            exec('cat /sys/class/net/'.$interface['name'].'/statistics/rx_bytes', $getBandwidth_rx);

            $data['network'][] = array(
                'interface' => $interface['name'],
                'ip'        => $interface['ip'],
                'transmit'  => self::getSize($getBandwidth_tx[0]),
                'receive'   => self::getSize($getBandwidth_rx[0]),
            );

            unset($getBandwidth_tx, $getBandwidth_rx);
        }

        return $data;
    }
}