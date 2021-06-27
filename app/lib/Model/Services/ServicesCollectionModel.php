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

namespace Kristuff\Minitoring\Model\Services;

use Kristuff\Minitoring\Model\System\SystemBaseModel;
use Kristuff\Miniweb\Auth\Model\UserLoginModel;
use Kristuff\Miniweb\Core\Json;
use Kristuff\Miniweb\Mvc\TaskResponse;

/** 
 * ServiceCheckerModel
 */
class ServicesCollectionModel extends SystemBaseModel
{
    /**
     * @var array
     */
    private static $availableProtocols = ['tcp', 'udp'];

    /** 
     * Create the tables 'system_service' and 'system_service_check' and populates
     * the table with default services  
     *
     * @access public
     * @static
     * @param Database      $database
     * 
     * @return bool         True if the table has been created, otherwise False
     */
    public static function setup(&$database = null)
    {
        if (!$database){
            $database = self::database();
            $database->table('service_check_detail')->drop(true);
            $database->table('service_check')->drop(true);
            $database->table('system_service')->drop(true);
            $database->table('system_service_check')->drop(true);
            $database->table('service')->drop(true);
        }
        $serviceTableQuery = $database->table('system_service')
                    ->create()
                        ->column('service_id',                  'int',           'NOT NULL',   'PK',  'AI')               
                        ->column('service_name',                'varchar(64)',   'NOT NULL')
                        ->column('service_ctlname',             'varchar(64)',   'NULL')
                        ->column('service_check_port',          'smallint',      'NOT NULL', 'DEFAULT', 0)
                        ->column('service_host',                'varchar(64)',   'NULL')
                        ->column('service_port',                'int',           'NULL')
                        ->column('service_protocol',            'varchar(10)',   'NULL')
                        ->column('service_check_enabled',       'smallint',      'NOT NULL', 'DEFAULT', 0);

        $serviceCheckTableQuery = $database->table('system_service_check')
                    ->create()
                        ->column('service_check_id',        'int',      'NOT NULL',   'PK',  'AI')
                        ->column('service_id',              'int',      'NOT NULL')
                        ->column('service_check_timestamp', 'int',      'NOT NULL')
                        ->column('service_check_cron',      'smallint', 'NOT NULL',   'DEFAULT', 0)
                        ->column('service_check_status',    'int',      'NOT NULL')
                        ->fk('fk_system_service_check', 'service_id', 'system_service', 'service_id');
                      
       return $serviceTableQuery->execute() && 
              $serviceCheckTableQuery->execute() &&
              self::populateWithDefaults($database);
    }

    /** 
     * Populates the table 'system_service' with default services  
     *
     * @access public
     * @static
     * @param Database      $database
     * 
     * @return bool         True if the table has been created, otherwise False
     */
    public static function populateWithDefaults(&$database)
    {
        $return = true;
        $query = $database->insert('system_service')
                          ->prepare('service_name', 
                                    'service_host', 
                                    'service_check_port', 
                                    'service_port', 
                                    'service_protocol', 
                                    'service_check_enabled');

        foreach (Json::fromFile(self::config('CONFIG_DEFAULT_PATH') . 'minitoring.services.default.json')   as $service){
            
            $protocol   = isset($service['protocol']) && in_array($service['protocol'], self::$availableProtocols) ? $service['protocol'] : 'tcp';
            $check_port = isset($service['check_port']) ? ($service['check_port'] ? 1 : 0) : 0; 
            $port       = isset($service['port']) ? (int) $service['port'] : null; 
            $name       = isset($service['name']) ? $service['name'] : null; 
            $host       = isset($service['host']) ? $service['host'] : 'localhost'; 

            $query->values([
                'service_name'          => $name, 
                'service_host'          => $host, 
                'service_check_port'    => $check_port, 
                'service_port'          => $port, 
                'service_protocol'      => $protocol, 
                'service_check_enabled' => 1
            ]);

            if (!$query->execute()){
                $return = false;
            }            
        }
        return $return;   
   }
   
    /** 
     * Get service list
     *
     * @access public
     * @static
     * @param int      $enableState         Current state. Default is -1 (all)
     * 
     * @return array
     */
    public static function getServicesList(int $enabledState = -1): array
    {
        $query = self::database()->select()
                               ->column('service_id')
                               ->column('service_name')
                               ->column('service_ctlname')
                               ->column('service_host')
                               ->column('service_check_port')
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

      //TODO
      public static function setCheckState(?int $serviceId = null, int $state = 1): TaskResponse
      {
            $response = TaskResponse::create();
            
            // Check admin permissions, not empty ID and valid state   
            if (UserLoginModel::validateAdminPermissions($response) &&
                $response->assertFalse(empty($serviceId) || !in_array($state, [0, 1]), 422,'TODO')){
                  
                $response->assertTrue(
                    self::database()->update('system_service')
                                    ->setValue('service_check_enabled', $state)
                                    ->whereEqual('service_id', $serviceId)
                                    ->execute(), 
                    500, 'TODO');
            }

            return $response;
    }

    /** 
     * Deletes a service entry in database (internal function)
     * 
     * @access public
     * @static
     * @param int           $id        The service id
     * 
     * @return bool       
     */
    protected static function deleteById(int $id): bool
    {
        return self::database()->delete('system_service')
                               ->whereEqual('service_id', $id)
                               ->execute();

                               //todo child 
    }

     /** 
     * Deletes a service from database
     * 
     * @access public
     * @static
     * @param int           $id         The service id 
     * 
     * @return  \Kristuff\Miniweb\Mvc\Taskresponse
     */
    public static function delete(int $id): TaskResponse
    {
        $response = TaskResponse::create();

        // Check admin permissions
        if (UserLoginModel::validateAdminPermissions($response)) {
            $response->assertTrue(self::deleteById($id), 500, self::text('ERROR_UNEXPECTED'));
        }

        return $response;
    }

    //todo check
    public static function add(string $serviceName, ?string $serviceHost = null, ?int $servicePort = null, bool $checkPort = false, string $serviceProtocol = 'tcp', ?string $serviceCtlName = null): TaskResponse
    {
        $response = TaskResponse::create();
            
        // Check admin permissions, file exists, Name not empty and unique   
        // Do not check file is readable here: in most case its not readable by webserver
        // but will be exposeD by dedicated socket api
        if ( UserLoginModel::validateAdminPermissions($response) 
                && $response->assertFalse(empty($serviceName), 400, self::text('ERROR_SERVICE_NAME_EMPTY')) 
                && $response->assertFalse(self::serviceNameExists($serviceName), 400, self::text('ERROR_SERVICE_NAME_ALREADY_EXISTS'))
                
            // TODO name lenght
        ) {
            if ($response->assertTrue(
                self::database()
                    ->insert('system_service')
                    ->setValue('service_name', $serviceName)
                    ->setValue('service_port', $servicePort)
                    ->setValue('service_protocol', $serviceProtocol)
                    ->setValue('service_check_port', $checkPort ? 1 : 0)
                    ->setValue('service_check_enabled', 1)
                    ->setValue('service_host', $serviceHost)
                    ->setValue('service_ctlname', $serviceCtlName)
                    ->execute()
                , 500, 
                self::text('ERROR_UNEXPECTED'))){ //todo

                $response->setMessage(self::text('')); 
            }
        }

        return $response;   
    }

    //todo check
    public static function edit(int $serviceId, string $serviceName, ?string $serviceHost = null, ?int $servicePort = null, bool $checkPort = false, string $serviceProtocol = 'tcp', ?string $serviceCtlName = null): TaskResponse
    {
        $response = TaskResponse::create();
            
        // Check admin permissions, file exists, Name not empty and unique   
        // Do not check file is readable here: in most case its not readable by webserver
        // but will be exposeD by dedicated socket api
        if ( UserLoginModel::validateAdminPermissions($response) 
                && $response->assertFalse(empty($serviceName), 400, self::text('ERROR_SERVICE_NAME_EMPTY')) 
                && $response->assertFalse(self::serviceNameExists($serviceName, $serviceId), 400, self::text('ERROR_SERVICE_NAME_ALREADY_EXISTS'))
                
            // TODO name lenght
        ) {
            if ($response->assertTrue(
                self::database()
                    ->update('system_service')
                    ->setValue('service_name', $serviceName)
                    ->setValue('service_port', $servicePort)
                    ->setValue('service_protocol', $serviceProtocol)
                    ->setValue('service_check_port', $checkPort ? 1 : 0)
                    ->setValue('service_check_enabled', 1)
                    ->setValue('service_host', $serviceHost)
                    ->setValue('service_ctlname', $serviceCtlName)
                    ->whereEqual('service_id', $serviceId)
                    ->execute()
                , 500, 
                self::text('ERROR_UNEXPECTED'))){ //todo

                $response->setMessage(self::text('')); 
            }
        }

        return $response;   
    }

    /** 
     * Gets whether the following service name exists
     * 
     * @access public
     * @static
     * @param string    $name           The name to check
     * @param int       $Id             The current service id. When set, ignore that Id. Default is null.
     *                                  (Needed when editing a service entry).    
     * 
     * @return bool
     */
    public static function serviceNameExists(string $name, ?int $id = null): bool
    {
        $query = self::database()->select()
                                 ->column('system_name')
                                 ->from('system_service')
                                 ->whereEqual('service_name', $name);

        if (isset($logId)){
            $query->where()->notEqual('service_id', $id);
        }                                 
                               
        $items = $query->getAll();
        return count($items) > 0;
    }
}