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

use Kristuff\Minitoring\Model\Services\ServicesCollectionModel;
use Kristuff\Minitoring\Model\System\SystemBaseModel;

/** 
 * ServiceModel
 */
class ServiceModel extends SystemBaseModel
{

    //todo
    public static function getCheckedServicesList()
    {
        $services = ServicesCollectionModel::getServicesList(1);
        foreach($services as &$service){

            if ($service['service_check_port'] ){
                $service['service_port_open'] = self::scanPort($service['service_host'], $service['service_port'], $service['service_protocol']);
                $service['service_check_timestamp'] = time(); 
            } else {
                //TODO
            }

        }
        return $services;
    }
  
    //todo
    public static function countProcess($serviceName)
    {

        $state = exec('pgrep -c ' . $serviceName);
        //return $state ? true : false;
    }

    /**
     * Checks if a port is open (TCP or UDP)
     * 
     * @static
     * @param string    $host       Host to check
     * @param int       $port       Port number
     * @param string    $protocol   tcp or udp
     * @param integer   $timeout    Timeout
     *
     * @return bool                 True if the port is open, otherwise false
     */
    private static function scanPort(string $host, int $port, string $protocol = 'tcp', int $timeout = 3)
    {
        if ($protocol == 'tcp'){
            $handle = @fsockopen($host, $port, $errno, $errstr, $timeout);

            if (!$handle){
                return false;
            }

            fclose($handle);
            return true;
        
        } elseif ($protocol == 'udp'){
            $handle = @fsockopen('udp://'.$host, $port, $errno, $errstr, $timeout);
            socket_set_timeout($handle, $timeout);

            $write = fwrite($handle, 'x00');
            $startTime = time();
            $header = fread($handle, 1);
            $endTime = time();
            $timeDiff = $endTime - $startTime; 
            fclose($handle);

            return ($timeDiff >= $timeout);
        }

        return false;
    }

    //todo
    public static function checkSystemCtl(string $serviceName)
    {
        $state = shell_exec('systemctl is-active --quiet ' . $serviceName . ' && echo 1');
        return $state ? true : false;
    }
}