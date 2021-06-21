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
 * @version    0.1.2
 * @copyright  2017-2021 Kristuff
 */

/**
 *      This file contains the default config. 
 * 
 *      ---------------------
 *      !!! DO NOT MODIFY !!!
 *      ---------------------
 * 
 *      If you modify directly this file, your changes will be overwritten 
 *      each time you update this app with composer. Instead, create a file 
 *      named 'minitoring.conf.local.php' in the same directory and overwrite 
 *      the keys you want. 
 *      
 *      sample :
 * 
 *      <?php
 *      return array( 
 *          'AUTH_LOGIN_COOKIE_ENABLED'      => true,
 * 
 *      )
 *
 * 
 */
return array( 

    /** 
     * *************************************
     * Configuration for: miniweb mvc system
     * *************************************
     */
    'CONTROLLER_NAMESPACE'      => 'Kristuff\\Minitoring\\Controller\\',
    'CONTROLLER_EXTENSION'      => 'Controller',
    'CONTROLLER_UCWORDS'        => true,
    'CONTROLLER_DEFAULT'        => 'index',
    'CONTROLLER_ACTION_DEFAULT' => 'index',
    'CONTROLLER_PATH'           => __DIR__ . '/../lib/Controller/',
    'VIEW_PATH'                 => __DIR__ . '/../view/',
    'CONFIG_PATH'               => __DIR__ . '/',
    'CONFIG_DEFAULT_PATH'       => __DIR__ . '/default/',
    
    'COOKIE_SECURE'             => true,
    'COOKIE_SAMESITE'           => 'Strict',

    /** 
     * *********************************
     * Configuration for: minitoring app
     * *********************************
     */
    'APP_NAME'                  =>  'Minitoring',
    'APP_COPYRIGHT'             =>  'Kristuff',
    'APP_VERSION'               =>  '0.1.2',
    'APP_DEFAULT_LANGUAGE'      =>  'en-US',
 
    'DATA_PATH'                 => __DIR__ . '/../data/',
    'DATA_CONFIG_PATH'          => __DIR__ . '/../data/config/',
    'DATA_DB_PATH'              => __DIR__ . '/../data/db/',
    'DATA_LOG_PATH'             => __DIR__ . '/../data/log/',

    'USER_AVATAR_PATH'          => __DIR__ . '/../data/avatar/',
    'USER_AVATAR_URL'           => 'ressources/avatar/',
    'USER_AVATAR_DEFAULT_IMAGE' => 'default.jpg',

    /** 
     * ***********************************************************
     * Configuration for: miniweb auth / login / password recovery
     * ***********************************************************
     */
    'AUTH_LOGIN_COOKIE_ENABLED'                  => false,
    'AUTH_PASSWORD_RESET_ENABLED'                => false,
    'AUTH_INVITATION_ENABLED'                    => true,
    'AUTH_SIGNUP_ENABLED'                        => false, // not implemented
    'AUTH_EMAIL_HTML'                            => true, // experimental..

    'AUTH_EMAIL_FROM_EMAIL'                      => 'no-reply@minitoring.kristuff.fr',
    'AUTH_EMAIL_FROM_NAME'                       => 'The Minitoring team',

    // TODO remove
    'AUTH_PASSWORD_RESET_MAIL_FROM_EMAIL'        => 'no-reply@minitoring.kristuff.fr',
    'AUTH_PASSWORD_RESET_MAIL_FROM_NAME'         => 'The Minitoring team',
    'AUTH_PASSWORD_RESET_MAIL_SUBJECT'           => 'Password reset for Minitoring application',
    'AUTH_PASSWORD_RESET_MAIL_CONTENT'           => 'Please click on this link to reset and set a new password: ',


    /** 
     * *******************************************
     * Configuration for: minitoring websocket api
     * *******************************************
     */
    'WEBCOCKET_PORT'            => 12443,
    'WEBCOCKET_USE_SECURE'      => false,
    'WEBCOCKET_CERT_PATH'       => '',
    'WEBCOCKET_KEY_PATH'        => '',
 
); 