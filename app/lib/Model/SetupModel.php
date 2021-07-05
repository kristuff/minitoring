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

namespace Kristuff\Minitoring\Model;

use Kristuff\Miniweb\Auth;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Minitoring\Model\Log;
use Kristuff\Patabase\Database;

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
       $response = TaskResponse::create();

        if ($response->assertTrue(self::request()->method() === 'GET', 405, 'Invalid method')) {
            self::performChecks($response);
        }
       
        $response->setMessage( $response->success() ? self::text('SETUP_CHECK_SUCCESSFULL') : self::text('SETUP_CHECK_HAS_ERROR') );
        
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
     * 
     * @access private
     * @static 
	 * @param string        $settingName
     * @param mixed         $value
     * 
     * @return bool
     */
    private static function updateAppSettingsByName(Database  $db, string $settingName, $value): bool
    {
        
        $query = $db->update('app_setting')
                    ->setValue('settingValue', $value)
                    ->whereEqual('settingName', $settingName);
        return $query->execute() && $query->rowCount() === 1;          
    }

     /**
     * 
     * @access private
     * @static 
	 * @param string        $settingName
     * @param mixed         $value
     * 
     * @return bool
     */
    private static function updateUserSettingsByName(Database $db, int $userId, string $settingName, $value): bool
    {
        $query = $db->update('user_setting')
            ->setValue('settingValue', $value)
            ->whereEqual('settingName', $settingName)
            ->whereEqual('userId', (int) $userId);

        return $query->execute() && $query->rowCount() === 1;          
    }




    /**
     * Install process
     * 
     * @access public
     * 
     */
    public static function install(string $databaseName, string $adminName, string $adminPassword, string $adminEmail, ?string $language = null)
    {
        // the return response
        $response = TaskResponse::create();
 
        $databaseFilePath = realpath(self::config('DATA_DB_PATH')). '/'. $databaseName .'.db';
        $lang = isset($language) && in_array($language, ['fr-FR','en-US']) ? $language : self::config('APP_LANGUAGE');
        
        // validate input
        if (    Auth\Model\UserModel::validateUserNamePattern($response, $adminName)  
            &&  Auth\Model\UserModel::validateUserEmailPattern($response, $adminEmail, $adminEmail)
            &&  Auth\Model\UserModel::validateUserPassword($response, $adminPassword, $adminPassword)
            &&  $response->assertFalse(file_exists($databaseFilePath), 500, self::text('SETUP_ERROR_DATABASE_EXISTS')) 
        ){
            
            // create datatabase, 
            // create tables
            $database   = self::createSqliteDatabase($databaseFilePath);
            if ($response->assertTrue($database !== false, 500, self::text('SETUP_ERROR_CREATE_DATABASE')) &&
                $response->assertTrue(self::createTables($database), 500, self::text('SETUP_ERROR_CREATE_TABLES')))  {

                // insert admin user
                $adminId = Auth\Model\UserAdminModel::insertAdminUser($adminEmail, $adminName, $adminPassword, $database);
                if ($response->assertFalse($adminId === false, 500, self::text('SETUP_ERROR_CREATE_ADMIN_USER'))) {

                    // load default settings app/user
                    // save config file
                    if (    $response->assertTrue(Auth\Model\AppSettingsModel::loadDefaultAppSettings($database), 500, self::text('SETUP_ERROR_CREATE_LOAD_APP_SETTINGS')) 
                        &&  $response->assertTrue(Auth\Model\UserSettingsModel::loadDefaultSettings($database, (int) $adminId), 500, self::text('SETUP_ERROR_CREATE_LOAD_USER_SETTINGS')) 
                        &&  $response->assertTrue(self::createDatabaseConfigFile('sqlite', 'localhost', $databaseFilePath, '', ''), 500, self::text('SETUP_ERROR_CREATE_CONF_FILE'))
                        &&  $response->assertTrue(self::updateAppSettingsByName($database, 'UI_LANG', $lang), 500, 'Grrr settings ui')
                        &&  $response->assertTrue(self::updateUserSettingsByName($database, $adminId, 'UI_LANG', $lang), 500, 'Grrr settings user')
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