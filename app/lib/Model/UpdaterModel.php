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
 * @version    0.1.21
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model;

use Kristuff\Minitoring\Application;
use Kristuff\Minitoring\Model\Collection;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Mishell\Console;
use Kristuff\Miniweb\Core\Json;
use Kristuff\Miniweb\Core\Path;

/** 
 * UpdaterModel
 */
class UpdaterModel extends \Kristuff\Miniweb\Data\Model\DatabaseModel
{

    private static $app;

    public static function performUpdate()
    {
        // need an app instance running to make static methods working. 
        self::$app = new Application();
        $response = self::createResponse();

        if (SetupModel::isInstalled()){
            $db = self::database();
            $schemaVersion = $db->select('settingValue')->from('app_setting')->whereEqual('settingName', 'SCHEMA_VERSION')->getColumn();

            if (empty($schemaVersion)){
                $schemaVersion = Application::VERSION;
                $response->assertTrue($db->insert('app_setting')
                                         ->values([
                                            'settingName' => 'SCHEMA_VERSION',
                                            'settingValue' => $schemaVersion,
                                          ])
                                          ->execute(),
                    500, 
                    'Error: Unable to register schema version.'
                );
            }
            self::printResponseOnError($response);

            $schemaVersion = str_replace('v','',$schemaVersion);

            // the schema version has been implemented in v0.1.19
            if (version_compare($schemaVersion, '0.1.19') <= 0) {

                // ping feature deployed in v0.1.19
                if (!$db->tableExists('system_ping')) {

                    $response->assertTrue(Collection\PingCollectionModel::setup($db), 500,   'Error: Unable to create ping setting table.');   
                    self::printResponseOnError($response);
                }
            }

            // update app settings
            $response->assertTrue(self::handleNewAppSettings(), 500,   'Error: Unable to update new app setting keys.');
            self::printResponseOnError($response);

            // update new shema version
            $response->assertTrue($db->update('app_setting')
                                     ->setValue('settingValue', Application::VERSION)
                                     ->whereEqual('settingName','SCHEMA_VERSION')
                                     ->execute(), 
                    500, 'Error: Unable to update schema version.');

            Console::log('Minitoring updater schema run without problem.');
        }
    }


    /** 
     * 
     * @access public
     * @static
     *
     * @return bool
     */
    public static function handleNewAppSettings()
    {
        $confileJsonFile = self::config('CONFIG_DEFAULT_PATH') . 'app.settings.default.json';

        if (!Path::fileExists($confileJsonFile)){
            return false;
        }
        
        $query = self::database()->insert('app_setting')
                                 ->prepare('settingName', 'settingValue');


                                 
        foreach (Json::fromFile($confileJsonFile) as $item){

            if (count(self::database()->select('settingValue')
                                      ->from('app_setting')
                                      ->whereEqual('settingName', $item['name'])
                                      ->getAll()) === 0) {

                $query->values([
                    'settingName'   => $item['name'], 
                    'settingValue'  => $item['value'] 
                ]);
    
                if (!$query->execute()){
                    return false;
                }            
    
            }
        }
        return true;   
    }


    protected static function printResponseOnError(TaskResponse $response){
        if (!$response->success()){
            Console::log('Minitoring updater error:');
            Console::log($response->errors()[0]['message']);
            exit(1);
        }

    }

}