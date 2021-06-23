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

namespace Kristuff\Minitoring\Model\Services;

use Kristuff\Minitoring\Model\System\SystemBaseModel;
use Kristuff\Miniweb\Core\Json;

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
                        ->column('service_check_port',          'smallint',      'NOT NULL')
                        ->column('service_host',                'varchar(64)',   'NULL')
                        ->column('service_port',                'int',           'NULL')
                        ->column('service_protocol',            'varchar(10)',   'NULL')
                        ->column('service_check_enabled',       'smallint',      'NOT NULL');

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
                                    'service_port', 
                                    'service_protocol', 
                                    'service_check_enabled');

        foreach (Json::fromFile(self::config('CONFIG_DEFAULT_PATH') . 'minitoring.services.default.json')   as $service){
            
            $protocol   = isset($service['protocol']) && in_array($service['protocol'], self::$availableProtocols) ? $service['protocol'] : 'tcp';
            $port       = isset($service['port']) ? (int) $service['port'] : null; 
            $name       = isset($service['name']) ? $service['name'] : null; 
            $host       = isset($service['host']) ? $service['host'] : 'localhost'; 

            $query->values([
                'service_name' => $name , 
                'service_host' => $host, 
                'service_port' => $port, 
                'service_protocol' => $protocol, 
                'service_check_enabled' => 1
            ]);

            if (!$query->execute()){
                $return = false;
            }            
        }
        return $return;   
   }

}