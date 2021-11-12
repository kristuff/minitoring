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
 * @version    0.1.20
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\Collection;

use Kristuff\Minitoring\Model\System\SystemBaseModel;
use Kristuff\Miniweb\Auth\Model\UserLoginModel;
use Kristuff\Miniweb\Core\Json;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Patabase\Database;
use Kristuff\Patabase\Output as PatabaseOutput;

/** 
 * PingCollectionModel
 */
class PingCollectionModel extends SystemBaseModel
{
    /** 
     * Create the table 'system_ping' and populates
     * the table with default hosts  
     *
     * @access public
     * @static
     * @param Database      $database
     * 
     * @return bool         True if the table has been created, otherwise False
     */
    public static function setup(Database $database = null)
    {
        if (!$database){
            $database = self::database();
            $database->table('system_ping')->drop();
        }
        $pingTableQuery = $database->table('system_ping')
                    ->create()
                        ->column('ping_id',                  'int',           'NOT NULL',   'PK',  'AI')               
                        ->column('ping_host',                'varchar(64)',   'NOT NULL')
                        ->column('ping_check_enabled',       'smallint',      'NOT NULL', 'DEFAULT', 0);
                      
        return  $pingTableQuery->execute() && 
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
    public static function populateWithDefaults(Database $database)
    {
        $return = true;
        $query = $database->insert('system_ping')
                          ->prepare('ping_host', 
                                    'ping_check_enabled');

        foreach (Json::fromFile(self::config('CONFIG_DEFAULT_PATH') . 'minitoring.ping.default.json') as $host){
            
            $query->values([
                'ping_host'          => $host, 
                'ping_check_enabled' => 1
            ]);

            if (!$query->execute()){
                $return = false;
            }            
        }
        return $return;   
    }
    
    /** 
     * Get host list
     *
     * @access public
     * @static
     * @param int       $enableState            Current state. Default is -1 (all)
     * 
     * @return array
     */
    public static function getList(int $enabledState = -1): array
    {
        $query = self::database()->select()
                               ->column('ping_id')
                               ->column('ping_host')
                               ->column('ping_check_enabled')
                               ->from('system_ping')
                               ->orderAsc('ping_host');

        // filter
        if (in_array($enabledState, [0, 1])){
            $query->whereEqual('ping_check_enabled', $enabledState);
        }
       
        return $query->getAll(PatabaseOutput::ASSOC);
    }

    //TODO
    public static function setCheckState(?int $pingId = null, int $state = 1): TaskResponse
    {
        $response = TaskResponse::create();
            
        // Check admin permissions, not empty ID and valid state   
        if (UserLoginModel::validateAdminPermissions($response) &&
            $response->assertFalse(empty($pingId) || !in_array($state, [0, 1]), 422,'TODO')){
                  
                $response->assertTrue(
                    self::database()->update('system_ping')
                                    ->setValue('ping_check_enabled', $state)
                                    ->whereEqual('ping_id', $pingId)
                                    ->execute(), 
                    500, 'TODO');
            }

            return $response;
    }

    /** 
     * Deletes a ping entry in database (internal function)
     * 
     * @access public
     * @static
     * @param int           $id        The host id
     * 
     * @return bool       
     */
    protected static function deleteById(int $id): bool
    {
        return self::database()->delete('system_ping')
                               ->whereEqual('ping_id', $id)
                               ->execute();
    }

    /** 
     * Deletes a ping entry from database
     * 
     * @access public
     * @static
     * @param int           $id         The host id 
     * 
     * @return  Taskresponse
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
    public static function add(string $host): TaskResponse
    {
        $response = TaskResponse::create();
        $query = self::database()->insert('system_ping')
                                 ->setValue('ping_host', $host)
                                 ->setValue('ping_check_enabled', 1);

        // Check admin permissions, not empty and unique host   
        if ( UserLoginModel::validateAdminPermissions($response) 
                && $response->assertFalse(empty($host), 400, self::text('ERROR_PING_HOST_EMPTY')) 
                && $response->assertFalse(self::hostExists($host), 400, self::text('ERROR_PING_HOST_ALREADY_EXISTS'))
                && $response->assertTrue($query->execute(), 500, self::text('ERROR_UNEXPECTED'))
        ){ //todo
            $response->setMessage(self::text('')); 
        }

        return $response;   
    }

    //todo check
    public static function edit(int $id, string $host): TaskResponse
    {
        $response = TaskResponse::create();
        $query = self::database()->update('system_ping')
                                 ->setValue('ping_host', $host)
                              // ->setValue('ping_check_enabled', 1)
                                 ->whereEqual('ping_id', $id);
        
        // Check admin permissions, not empty and unique host   
        if ( UserLoginModel::validateAdminPermissions($response) 
             && $response->assertFalse(empty($host), 400, self::text('ERROR_PING_HOST_EMPTY')) 
             && $response->assertFalse(self::hostExists($host, $id), 400, self::text('ERROR_PING_HOST_ALREADY_EXISTS'))
             && $response->assertTrue($query->execute(), 500, self::text('ERROR_UNEXPECTED'))
        ){
            $response->setMessage(self::text('')); 
        }

        return $response;   
    }

    /** 
     * Gets whether the following host exists
     * 
     * @access public
     * @static
     * @param string    $name           The hostname to check
     * @param int       $Id             The current id. When set, ignore that Id. Default is null.
     *                                  (needed when editing an entry).    
     * 
     * @return bool
     */
    public static function hostExists(string $name, ?int $id = null): bool
    {
        $query = self::database()->select()
                                 ->column('ping_host')
                                 ->from('system_ping')
                                 ->whereEqual('ping_host', $name);

        if (isset($id)){
            $query->where()->notEqual('ping_id', $id);
        }                                 
                               
        $items = $query->getAll();
        return count($items) > 0;
    }
}