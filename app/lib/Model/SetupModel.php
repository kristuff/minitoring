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
 * @version    0.1.8
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model;

use Kristuff\Miniweb\Auth;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Minitoring\Model\Log;
use Kristuff\Minitoring\Model\Log\LogsCollectionModel;
use Kristuff\Patabase\Driver\Sqlite\SqliteDatabase;
use Kristuff\Mishell\Console;

/** 
 * SetupModel
 */
class SetupModel extends \Kristuff\Miniweb\Data\Model\SetupModel
{
    /** 
     * Perform some checks 
     */
    public static function checkForInstall()
    {
       // the return response
       $response = TaskResponse::create();

       if ($response->assertTrue(self::request()->method() === 'GET', 405, 'Invalid method')) {
            self::performChecks($response);
       }
       
       if ( $response->success() ){
           $response->setMessage(self::text('SETUP_CHECK_SUCCESSFULL'));        
       }
       return $response;
    } 
    
  
    /** 
     * Perform some checks 
     */
   public static function performChecks(TaskResponse $response)
   {
        $response->assertTrue(file_exists(self::config('DATA_PATH')),                500, sprintf(self::text('ERROR_PATH_MISSING'), 'data'));
        $response->assertTrue(is_writable(self::config('DATA_PATH')),                500, sprintf(self::text('ERROR_PATH_PERMISSIONS'), 'data'));
        $response->assertTrue(file_exists(self::config('DATA_CONFIG_PATH')),         500, sprintf(self::text('ERROR_PATH_MISSING'), 'config'));
        $response->assertTrue(is_writable(self::config('DATA_CONFIG_PATH')),         500, sprintf(self::text('ERROR_PATH_PERMISSIONS'), 'config'));
        $response->assertTrue(file_exists(self::config('DATA_LOG_PATH')),            500, sprintf(self::text('ERROR_PATH_MISSING'), 'logs'));
        $response->assertTrue(is_writable(self::config('DATA_LOG_PATH')),            500, sprintf(self::text('ERROR_PATH_PERMISSIONS'), 'logs'));
        $response->assertTrue(file_exists(Auth\Model\UserAvatarModel::getPath()),    500, sprintf(self::text('ERROR_PATH_MISSING'), 'avatar'));
        $response->assertTrue(is_writable(Auth\Model\UserAvatarModel::getPath()),    500, sprintf(self::text('ERROR_PATH_PERMISSIONS'), 'avatar'));

        return $response;
   }

    /**
     * 
     * @access public
     * 
     * @return bool
     */
    public static function testConnexion(string $databaseName, string $databaseHost, string $adminName, string $adminPassword)
    {

        //todo
    }


    /**
     * Install process
     * 
     * @access public
     * 
     */
    public static function install(string $adminName, string $adminPassword, string $adminEmail, string $databaseName)
    {
        // the return response
        $response = TaskResponse::create();
 
        $databaseFilePath = realpath(self::config('DATA_DB_PATH')). '/'. $databaseName .'.db';
    
        // validate input
        if (Auth\Model\UserModel::validateUserNamePattern($response, $adminName) && 
            Auth\Model\UserModel::validateUserEmailPattern($response, $adminEmail, $adminEmail) &&
            Auth\Model\UserModel::validateUserPassword($response, $adminPassword, $adminPassword)){
            
            // create datatabase, 
            // create tables
            $database   = self::createSqliteDatabase($databaseFilePath);
            if ($response->assertTrue($database !== false, 500, 'Internal error : unable to create database') &&
                $response->assertTrue(self::createTables($database), 500, 'Internal error : unable to create tables'))  {

                // insert admin user
                $adminId = Auth\Model\UserAdminModel::insertAdminUser($adminEmail, $adminName, $adminPassword, $database);
                if ($response->assertFalse($adminId === false, 500, 'Internal error : unable to insert admin user')) {

                    // load default settings app/user
                    // save config file
                    if (    $response->assertTrue(Auth\Model\AppSettingsModel::loadDefaultAppSettings($database), 500, 'Internal error : unable to insert app settings data') 
                        &&  $response->assertTrue(Auth\Model\UserSettingsModel::loadDefaultSettings($database, (int) $adminId), 500, 'Internal error : unable to insert user settings data') 
                        &&  $response->assertTrue(self::createDatabaseConfigFile('sqlite', 'localhost', $databaseFilePath, '', ''), 500, 'Internal error : unable to create config file')
                    ) {
                        $response->setMessage(self::text('SETUP_INSTALL_SUCCESSFULL'));
                    }
                }
            }
        }

        return $response;
    }

    private static function createTables(&$database)
    {
        return Auth\Model\UserModel::createTable($database) &&
               Auth\Model\UserSettingsModel::createTableSettings($database) &&
               Auth\Model\AppSettingsModel::createTableSettings($database) &&
               Log\LogsCollectionModel::setup($database) &&
               Services\ServicesCollectionModel::setup($database);
    }
}