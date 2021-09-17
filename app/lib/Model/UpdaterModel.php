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
 * @version    0.1.19
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model;

use Kristuff\Minitoring\Application;
use Kristuff\Minitoring\Model\Collection;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Mishell\Console;

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

            // the schema version has been implemented in v0.1.19, deployed in v0.1.20 
            if (version_compare($schemaVersion, '0.1.19') <= 0){

                if (!$db->tableExists('system_ping')){
                    
                    // ping feature deployed in v0.1.20
                    $response->assertTrue(Collection\PingCollectionModel::setup($db), 500,   'Error: Unable to create ping setting table.');   
                    self::printResponseOnError($response);
                }
            }

            Console::log('Minitoring updater schema run without problem.');
        }
    }

    protected static function printResponseOnError(TaskResponse $response){
        if (!$response->success()){
            Console::log('Minitoring updater error:');
            Console::log($response->errors()[0]['message']);
            exit(1);
        }

    }

}