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
 * @version    0.1.6
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\System;

use Kristuff\Minitoring\Model\System\SystemBaseModel;

/** 
 * ServiceModel
 */
class ServiceModel extends SystemBaseModel
{
    //todo
    private static $showPortNumber = true; //TODO


    public static function checkSystemCtl($serviceName)
    {
        $state = shell_exec('systemctl is-active --quiet ' . $serviceName . ' && echo 1');
        return $state ? true : false;
    }
  
    public static function countProcess($serviceName)
    {

        $state = exec('pgrep -c ' . $serviceName);
        
        //return $state ? true : false;
    }



    
    //TODO
    public static function setCheckState($serviceId, $state = 1)
    {
       if (empty($serviceId) || !in_array($state, [-1, 0, 1])){
           return self::createResponse(422,'');
       }

       // TODO adm

       $query = self::database()->update('system_service')->setValue('service_check_enabled', $state)->whereEqual('service_id', $serviceId);
       $result =  $query->execute();
       return self::createResponse(($result === true ? 200 : 500),'');
   }



    public static function add($serviceName, $serviceHost, $servicePort, $checkStatus = 0,  $serviceProtocol = 'tcp')
    {
          
    }



    public static function check($isCron = 0)
    {
        // get service list (all) 
        $services = self::getServicesList();

        // prepare query
        $checkQuery = self::database()->insert('system_service_check')->prepare('service_check_timestamp', 
                                                                         'service_id', 
                                                                         'service_check_cron', 
                                                                         'service_check_status');
        // response data
        $datas = [];

        // check for each registered service
        foreach ($services as $service){
            $currentCheck = array('name' => $service['service_name']);

            // check service if check is enabled 
            if (!((int) $service['service_check_enabled'])){
                $currentCheck['result'] = -1; 
                continue;
            }
            
            // perform check
            $result   = self::scanPort($service['service_host'], $service['service_port'], $service['service_protocol']) ? 1 : 0;
            
            // udpate db 
            $checkQuery->values(
                ['service_id'               => $service['service_id'], 
                'service_check_timestamp'   => time(), 
                'service_check_cron'        => $isCron, 
                'service_check_status'      => $result]);
            $checkQuery->execute();
            
            // response 
            $currentCheck['result'] = $result;
            $datas[]= $currentCheck; 
        }

        return $datas;   
    }

    public static function getCheckedServicesList()
    {
        $services = self::getServicesList();
        foreach($services as &$service){
            $service['service_port_open'] = self::scanPort($service['service_host'], $service['service_port'], $service['service_protocol']);
            $service['service_check_timestamp'] = time(); 
        }
        return $services;
    }


    //todo
    public static function getServicesList($enabledState = -1)
    {
        $query = self::database()->select()
                               ->column('service_id')
                               ->column('service_name')
                               ->column('service_host')
                               ->column('service_port')
                               ->column('service_protocol')
                               ->column('service_check_enabled')
                               ->from('system_service')
                               ->orderAsc('service_name');
        // filter
        if (in_array($enabledState, [0, 1])){
            $query->whereEqual('service_check_enabled', $enabledState);
        }
       
        return $query->getAll('assoc');
    }

      //todo
    public static function getLastChecks($serviceId = null, $lastOnly = true, $limit = 50, $offset = 0)
    {
        $query= self::database()->select()
                               ->column('system_service.service_id')
                               ->column('system_service.service_name')
                               ->column('system_service.service_host')
                               ->column('system_service.service_port')
                               ->column('system_service.service_protocol')
                               ->column('system_service.service_check_enabled')
                               ->column('system_service_check.service_check_timestamp')
                               ->column('system_service_check.service_check_cron')
                               ->column('system_service_check.service_check_status')
                               ->from('system_service')
                               ->join('system_service_check', 'service_id', 'system_service', 'service_id')
                               ->orderDesc('system_service_check.service_check_timestamp')
                               ->orderAsc('system_service.service_name');

        if (!empty($serviceId)){
            $query->whereEqual('system_service.service_id', $serviceId);
        }

        if ($lastOnly){
            $query->groupBy('system_service.service_id');
        }

        $query->limit($limit);
        $query->offset($offset);

        return $query->getAll('assoc');
    }

       //todo
    public static function countChecks($serviceId = null)
    {
        $query= self::database()->select()
                                ->count('total')
                                ->from('system_service_check');

        if (!empty($serviceId)){
            $query->whereEqual('system_service_check.service_id', $serviceId);
        }

        return $query->getColumn();
    }

    /**
     * Checks if a port is open (TCP or UDP)
     * 
     * @static
     * @param  string   $host       Host to check
     * @param  int      $port       Port number
     * @param  string   $protocol   tcp or udp
     * @param  integer  $timeout    Timeout
     *
     * @return bool                 True if the port is open, otherwise false
     */
    private static function scanPort($host, $port, $protocol = 'tcp', $timeout = 3)
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
}