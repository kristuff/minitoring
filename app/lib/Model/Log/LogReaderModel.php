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
 * @version    0.1.11
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\Log;

use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Miniweb\Mvc\Model;
use Kristuff\Miniweb\Core\Json;
use Kristuff\Parselog\LogParserFactory;

/** 
 * LogReaderModel
 * Handle 
 */
class LogReaderModel extends Model
{
    /**
     * @var array
     */
    protected static $defaultSettings = [];

    /**
     * @var array
     */
    protected static $logTypes = [
        'syslog', 
        'apache_access', 
        'apache_error', 
        'fail2ban',
    ];

    /** 
     * Get the list of registered log types
     * 
     * @access public
     * @static
     * 
     * @return array        
     */
    public static function getDefaults(): array
    {
        if (empty(self::$defaultSettings)){
            $settings = Json::fromFile(self::config('CONFIG_DEFAULT_PATH') . 'minitoring.logs.default.json');
            self::$defaultSettings = $settings ?? [];
        }
        return self::$defaultSettings;
    }

    /** 
     * Get the list of registered log types
     * 
     * @access public
     * @static
     * 
     * @return array        
     */
    public static function getLogTypes(): array
    {
        return self::$logTypes;
    }

    /** 
     * Get the list of registered log format in a special array
     * 
     * @access public
     * @static
     * 
     * @return array        
     */
    public static function getLogFormats(): array
    {
        $default = self::getDefaults();
        $data = [];

        foreach($default as $logInfos){
            $baseName   = $logInfos['name'];
            $type       = $logInfos['type'];

            foreach ($logInfos['formats'] as $format){
                $data[] = [
                    'type'      => $type,
                    'name'      => $format['name'],
                    'longName'  => $baseName . ' (' . $format['name'] . ')',
                    'format'    => $format['format'],
                ];
            }
        }

        return $data;
    }

    /** 
     * Get the columns according to given log format.
     * Each column contains: code, name and display field
     * 
     * @access public
     * @static
     * @param string    $logType
     * @param string    $logFormat
     * 
     * @return array        
     */
    public static function getColumns(string $logType, string $logFormat): array
    {
        $cols = [];
        foreach (self::getDefaults() as $log){
            if ($log['type'] === $logType) {
                foreach ($log['columns'] as $column){
                    if (strpos($logFormat, $column['code']) !== false){
                        $cols[] = $column;
                    }
                }
                break;
            }
        }
        return $cols;
    }

    /** 
     * Read the given log file (according to its id) by the end. 
     * 
     * @access public
     * @static
     * @param int       $logId      
     * @param int       $limit      Default is 100
     * 
     * @return array        
     */
    public static function read(int $logId, int $limit = 100): TaskResponse
    {
        $log      = LogsCollectionModel::getById($logId);
        $response = TaskResponse::create(200);

        if ($response->assertTrue(isset($log), 500, 'Error when retrieving log info')){
 
            // get parser and open file 
            $parser = LogParserFactory::getParser($log->logType, !empty($log->logFormat) ? $log->logFormat : null);
            $logreader = new LogReader($parser, $log->logPath );
               
            // Returns an error if could not open file
            if ($response->assertTrue($logreader->open(), 500, "Error when opening file $log->logPath")){

                // populates response with data
                $data               = $logreader->getNewLines($limit);
                $data['columns']    = self::getColumns($log->logType, $parser->getFormat());
                $data['logFormat']  = $parser->getFormat();
                $data['logType']    = $log->logType;
                $data['logPath']    = $log->logPath;
                $response->setData($data);
            }
        }   

        return $response;
    }

    /** 
     * Scan and add availables logs 
     * For now skip logs that need to set format (apache acces and error)
     * 
     * @access public
     * @static
     * 
     * @return array        
     */
    public static function scanAvailablesLogs(): TaskResponse
    {
        $default = self::getDefaults();
        $numberAdded = 0;
        
        foreach($default as $logInfos){
            foreach($logInfos['paths'] as $path){
                foreach($logInfos['files'] as $file){

                    if (file_exists($path. $file)){

                        // check if already exists in db
                        if (!LogsCollectionModel::logPathExists($path. $file)){
                            // add item TODO FORMAT
                            LogsCollectionModel::add($path. $file, $logInfos['type'], $logInfos['name']);
                            $numberAdded++;
                        }
                    }
                }
            }
        }

        $data = [
            'numberAdded' => $numberAdded, 
        ];

        return TaskResponse::create(200,"",$data);
    }
}  

