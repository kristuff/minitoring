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
 * @version    0.1.20
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\Collection;

use Kristuff\Minitoring\Model\System\SystemBaseModel;
use Kristuff\Minitoring\Model\Log\LogReaderModel;
use Kristuff\Miniweb\Auth\Model\UserLoginModel;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Miniweb\Core\Path;
use Kristuff\Patabase\Database;

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
    public static function setup($database = null): bool
    {
        $database = $database ? $database: self::database();
        $executed = $database->table('system_log')
                          ->create()
                          ->column('logId',                 'int',          'NOT NULL', 'PK',  'AI')               
                          ->column('logName',               'varchar(64)',  'NOT NULL')
                          ->column('logType',               'varchar(64)',  'NOT NULL')
                          ->column('logPath',               'varchar(255)', 'NOT NULL')
                          ->column('logFormatName',         'varchar(64)',  'NOT NULL')
                          ->column('logFormat',             'varchar(255)', 'NOT NULL')
                          ->column('logDisplayedColumns',   'varchar(255)', 'NULL')
                          ->column('logFilters',            'varchar(255)', 'NULL')
                          ->execute();

        if ($executed){
            self::addDefaultLogs($database);
        }

        return $executed;
    }

    /** 
     * Load default log files
     *
     * @access protected
     * @static
     * 
     * @return  void        
     */
    protected static function addDefaultLogs($database): void
    {
        self::addLogFile($database, 'syslog',   'Syslog',       '/var/log/syslog',       'default');
        self::addLogFile($database, 'syslog',   'Messages',     '/var/log/messages',     'default');
        self::addLogFile($database, 'syslog',   'Auth',         '/var/log/auth.log',     'default');
        self::addLogFile($database, 'syslog',   'Daemon',       '/var/log/daemon.log',   'default');
        self::addLogFile($database, 'syslog',   'Kernel',       '/var/log/kern.log',     'default');
        self::addLogFile($database, 'syslog',   'Mail Error',   '/var/log/mail.err',     'default');
        self::addLogFile($database, 'syslog',   'Mail Info',    '/var/log/mail.info',    'default');
        self::addLogFile($database, 'syslog',   'Mail Warn',    '/var/log/mail.warn',    'default');
        self::addLogFile($database, 'fail2ban', 'Fail2Ban',     '/var/log/fail2ban.log', 'default');
    }

    /** 
     * Add a default log file
     *
     * @access protected
     * @static
     * 
     * @return  void        
     */
    protected static function addLogFile(Database $database, string $logType, string $logName, string $logPath, string $formatName = "default"): void
    {
        if (file_exists($logPath)){
            $database->insert('system_log')
                    ->setValue('logName', $logName)
                    ->setValue('logPath', $logPath)
                    ->setValue('logType', $logType)
                    ->setValue('logFormat', "")
                    ->setValue('logFormatName', $formatName)
                    ->execute();
        }
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
                                 ->column('logFormatName')
                                 ->column('logDisplayedColumns')
                                 ->column('logFilters')
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
                                 ->column('logFormatName')
                                 ->column('logDisplayedColumns')
                                 ->column('logFilters')
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
     * Gets whether the following logpath exists in database
     * 
     * @access public
     * @static
     * @param string    $logPath    The log file path to check
     * @param int       $logId      The current log id. When set, ignore that logId. Default is null.
     *                              (Needed when editing a log entry).    
     * 
     * @return bool
     */
    public static function logPathExists(string $logPath, ?int $logId = null): bool
    {
        $query = self::database()->select()
                                 ->column('logName')
                                 ->from('system_log')
                                 ->whereEqual('logPath', $logPath);

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
     * @param int           $id        The log id
     * 
     * @return bool       
     */
    protected static function deleteById(int $id)
    {
        return self::database()->delete('system_log')
                               ->whereEqual('logId', $id)
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
     * @param string        $logFormatName  The log file format name 
     * @param string        $logFormat      The log file format
     * 
     * @return  \Kristuff\Miniweb\Mvc\Taskresponse
     */
    public static function add(string $logPath, string $logType, string $logName, string $logFormatName = '', string $logFormat = '')
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
                    ->setValue('logFormatName', $logFormatName)
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
     * @param string        $logFormatName  The log file format name 
     * @param string        $logFormat      The log file format
     * 
     * @return  TaskResponse
     */
    public static function edit(int $logId, string $logPath, string $logType, string $logName, string $logFormatName = '', string $logFormat = ''): TaskResponse
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
                    ->setValue('logFormatName', $logFormatName)
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

}