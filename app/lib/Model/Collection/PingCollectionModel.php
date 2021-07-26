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
 * @version    0.1.17
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\Collection;

use Kristuff\Minitoring\Model\System\SystemBaseModel;
use Kristuff\Miniweb\Auth\Model\UserLoginModel;
use Kristuff\Miniweb\Core\Json;
use Kristuff\Miniweb\Mvc\TaskResponse;
use \Kristuff\Patabase\Output as PatabaseOutput;

/** 
 * ServiceCheckerModel
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
    public static function setup(&$database = null)
    {
        if (!$database){
            $database = self::database();
            $database->table('system_ping')->drop(true);
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
    public static function populateWithDefaults(&$database)
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
    public static function getServicesList(int $enabledState = -1): array
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
            $response->assertFalse(empty($serviceId) || !in_array($state, [0, 1]), 422,'TODO')){
                  
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

                               //todo child 
    }

    /** 
     * Deletes a ping entry from database
     * 
     * @access public
     * @static
     * @param int           $id         The host id 
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



    //todo
    //...



}