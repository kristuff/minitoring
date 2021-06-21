<?php declare(strict_types=1);

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
 * @version    0.1.2
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\Log;

use Kristuff\Minitoring\Model\System\SystemBaseModel;
use Kristuff\Minitoring\Model\Log\LogReader;
use Kristuff\Miniweb\Auth\Model\UserLoginModel;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Miniweb\Core\Path;
use Kristuff\Miniweb\Core\Json;

/** 
 * LogsModel
 * 
 * Handle logs settings storage
 */
class LogsCollectionModel extends SystemBaseModel
{
    /** 
     * Create the table system_log
     *
     * @access public
     * @static
     * @param Database      $database
     * 
     * @return  bool        True if the table has been created, otherwise False
     */
    public static function setup($db = null): bool
    {
        $database = $db ? $db: self::database();
        return $database->table('system_log')
                          ->create()
                          ->column('logId',                 'int',          'NOT NULL', 'PK',  'AI')               
                          ->column('logName',               'varchar(64)',  'NOT NULL')
                          ->column('logType',               'varchar(64)',  'NOT NULL')
                          ->column('logPath',               'varchar(255)', 'NOT NULL')
                          ->column('logFormat',             'varchar(128)', 'NOT NULL')
                          ->column('logDisplayedColumns',   'varchar(255)', 'NULL')
                          ->execute();
    }

    /** 
     * Recreates the table system_log
     *
     * @access public
     * @static
     * 
     * @return  bool        True if the table has been recreated, otherwise False
     */
    public static function reset(): bool
    {
        return self::database()->tableExists('system_log') ? 
               self::database()->dropTable('system_log') && self::setup() : 
               self::setup();
    }

    /** 
     * Get the list of registered log files
     * 
     * @access public
     * @static
     * 
     * @return array        
     */
    public static function getList(): array
    {
        $query = self::database()->select()
                                 ->column('logId')
                                 ->column('logName')
                                 ->column('logType')
                                 ->column('logPath')
                                 ->column('logFormat')
                                 ->column('logDisplayedColumns')
                                 ->from('system_log')
                                 ->orderAsc('logName');

        return $query->getAll('assoc');
    }

    /** 
     * Gets a log entry object for given id
     * 
     * @access public
     * @static
     * 
     * @return object|null        
     */
    public static function getById(int $logId)
    {
        $query = self::database()->select()
                                 ->column('logId')
                                 ->column('logName')
                                 ->column('logType')
                                 ->column('logPath')
                                 ->column('logFormat')
                                 ->column('logDisplayedColumns')
                                 ->from('system_log')
                                 ->whereEqual('logId', $logId)
                                 ->orderAsc('logName');

        $element = $query->getOne('obj');                                 
        return isset($element) ? $element[0] : null ;
    }

    /** 
     * Gets whether the following logname exists
     * 
     * @access public
     * @static
     * @param string    $logName    The log name to check
     * @param int       $logId      The current log id. When set, ignore that logId. Default is null.
     *                              (Needed when editing a log entry).    
     * 
     * @return bool
     */
    public static function logNameExists(string $logName, ?int $logId = null): bool
    {
        $query = self::database()->select()
                                 ->column('logName')
                                 ->from('system_log')
                                 ->whereEqual('logName', $logName);

        if (isset($logId)){
            $query->where()->notEqual('logId', $logId);
        }                                 
                               
        $items = $query->getAll();
        return count($items) > 0;
    }

    /** 
     * Deletes a log entry in database (internal function)
     * 
     * @access public
     * @static
     * 
     * @return bool       
     */
    protected static function deleteById(int $logId)
    {
        return self::database()->delete('system_log')
                               ->whereEqual('logId', $logId)
                               ->execute();
    }

    /** 
     * Adds a log file 
     * 
     * @access public
     * @static
     * @param string        $logPath        The log file full path 
     * @param string        $logType        The log file internal type
     * @param string        $logName        The log name 
     * @param string        $logFormat      The log file format
     * 
     * @return  \Kristuff\Miniweb\Mvc\Taskresponse
     */
    public static function add(string $logPath, string $logType, string $logName, string $logFormat = '')
    {
        // the return response
        $response = TaskResponse::create();


            
        // Check admin permissions, file exists, Name not empty and unique   
        // Do not check file is readable here: in most case its not readable by webserver
        // but will be exposeD by dedicated socket api
        if (UserLoginModel::validateAdminPermissions($response) &&
            $response->assertFalse(empty($logName), 400, self::text('ERROR_LOGNAME_EMPTY')) &&
            $response->assertFalse(self::logNameExists($logName), 400, self::text('ERROR_LOGNAME_ALREADY_EXISTS')) &&
            // TODO name lenght

            $response->assertTrue(Path::fileExists($logPath), 400, sprintf(self::text('ERROR_LOGFILE_NOT_FOUND'), $logPath)) &&
            // $response->assertTrue(Path::isfileReadable($logPath), sprintf(self::text('ERROR_LOGFILE_NOT_READABLE'), $logPath)) &&
            $response->assertTrue(in_array($logType, LogReaderModel::getLogTypes()), 400, sprintf(self::text('ERROR_LOGFILE_WRONG_TYPE'), $logType)) ){
            
            if ($response->assertTrue(
                self::database()
                    ->insert('system_log')
                    ->setValue('logName', $logName)
                    ->setValue('logPath', $logPath)
                    ->setValue('logType', $logType)
                    ->setValue('logFormat', $logFormat)
                    ->execute()
                , 500, 
                self::text('ERROR_UNEXPECTED'))){ //todo

                $response->setMessage(self::text(''));                       
            }
        }
        return $response;
    }

    /** 
     * Edit a log file 
     * 
     * @access public
     * @static
     * @param int           $logId          The log id 
     * @param string        $logPath        The log file full path 
     * @param string        $logType        The log file internal type
     * @param string        $logName        The log name 
     * @param string        $logFormat      The log file format
     * 
     * @return  \Kristuff\Miniweb\Mvc\Taskresponse
     */
    public static function edit(int $logId, string $logPath, string $logType, string $logName, string $logFormat = '')
    {
        $response = TaskResponse::create();
            
        // Check admin permissions, file exists, Name not empty and unique   
        // Do not check file is readable here: in most case its not readable by webserver
        // but will be exposed by dedicated socket api
        if (UserLoginModel::validateAdminPermissions($response) &&
            $response->assertFalse(empty($logName), 400, self::text('ERROR_LOGNAME_EMPTY')) &&
            $response->assertFalse(self::logNameExists($logName, $logId), 400, self::text('ERROR_LOGNAME_ALREADY_EXISTS')) &&
            $response->assertTrue(Path::fileExists($logPath), 400, sprintf(self::text('ERROR_LOGFILE_NOT_FOUND'), $logPath)) &&
            // $response->assertTrue(Path::isfileReadable($logPath), sprintf(self::text('ERROR_LOGFILE_NOT_READABLE'), $logPath)) &&
            $response->assertTrue(in_array($logType, LogReaderModel::getLogTypes()), 400, sprintf(self::text('ERROR_LOGFILE_WRONG_TYPE'), $logType))
            ) {
            
            if ($response->assertTrue(
                self::database()
                    ->update('system_log')
                    ->setValue('logName', $logName)
                    ->setValue('logPath', $logPath)
                    ->setValue('logType', $logType)
                    ->setValue('logFormat', $logFormat)
                    ->whereEqual('logId', $logId)
                    ->execute()
                , 500, 
                self::text('ERROR_UNEXPECTED'))){ //todo
                
                $response->setMessage(self::text(''));                       
            }
        }
        return $response;
    }

    /** 
     * Deletes a log file from database
     * 
     * @access public
     * @static
     * @param int           $logId          The log id 
     * 
     * @return  \Kristuff\Miniweb\Mvc\Taskresponse
     */
    public static function delete(int $logId)
    {
        $response = TaskResponse::create();

        // Check admin permissions
        if (UserLoginModel::validateAdminPermissions($response)) {
            $response->assertTrue(self::deleteById($logId), 500, self::text('ERROR_UNEXPECTED'));
        }

        return $response;
    }

    /**
     * 
     * @return array
     */
    public function getDefaults(): array
    {
       $defaults = Json::fromFile(self::config('CONFIG_DEFAULT_PATH') . 'minitoring.logs.default.json');
       return empty($defaults) ? [] : $defaults;
    }

}