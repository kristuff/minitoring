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
 * @version    0.1.1
 * @copyright  2017-2021 Kristuff
 */

/**
 * Texts used in the application.
 */
return array(

    /* app errors */
    'ERROR_UNEXPECTED'                                  => 'An unexpected error occurred',
    'ERROR_PATH_MISSING'                                => "Path '%s' does not exist",
    'ERROR_PATH_PERMISSIONS'                            => "Path '%s' is not writable (invalid permissions)",
    'ERROR_LOGFILE_NOT_FOUND'                           => "The file '%s' was not found.",
    'ERROR_LOGFILE_NOT_READABLE'                        => "The file '%s' is not readable (invalid permissions).",
    'ERROR_LOGFILE_WRONG_TYPE'                          => "The specified type '%s' is not a valid log type.",
    'ERROR_LOGNAME_ALREADY_EXISTS'                      => "A log with same name already exists. Please choose another name.",
    'ERROR_LOGNAME_EMPTY'                               => "You must set a log name.",

    /* UI */
    'BUTTON_OK'                                         => "OK",
    'BUTTON_CANCEL'                                     => "Cancel",
    'THEME_DARK'                                        => 'Dark',
    'THEME_LIGHT'                                       => 'Light',
    'COLOR_YELLOW'                                      => 'Yellow',
    'COLOR_RED'                                         => 'Red',
    'COLOR_GREEN'                                       => 'Green',
    'COLOR_BLUE'                                        => 'Blue',
    'COLOR_MAGENTA'                                     => 'Magenta',
    'COLOR_ORANGE'                                      => 'Orange',

    /* login */
    'AUTH_LOGIN_NAME_OR_EMAIL_FIELD'                    => 'User name or email:',
    'AUTH_LOGIN_NAME_OR_EMAIL_PLACEHOLDER'              => 'User name or email',
    'AUTH_LOGIN_PASSWORD_FIELD'                         => 'Password:',
    'AUTH_LOGIN_PASSWORD_PLACEHOLDER'                   => 'Password',
    'AUTH_LOGIN_REMEMBER_ME'                            => 'Remember me',
    'AUTH_LOGIN_BUTTON_TEXT'                            => 'Log in',
    'AUTH_LOGOUT_BUTTON_TEXT'                           => 'Log out ',
    'AUTH_FORGOT_PASSWORD_LINK'                         => 'Forgot password?',

    /* Logs */
    'LOGS'                                              => 'Logs',
    'LOGS_REFRESH_NONE'                                 => 'No refresh',
    'LOGS_REFRESH_XSECONDS'                             => 'Refresh each %ss',
    'LOGS_DISPLAY_XLINES'                               => 'Display %s lines',

    /* settings */
    'SETTINGS'                                          => 'Settings',

    /* settings customize */
    'SETTINGS_CUSTOMIZE'                                => 'Customize',
    'SETTINGS_CUSTOMIZE_SUMMARY'                        => 'Change language, appearance and default views',
    'SETTINGS_CUSTOMIZE_LANGUAGE'                       => 'Language',
    'SETTINGS_CUSTOMIZE_LANGUAGE_TEXT'                  => 'You need to reload the page to apply language changes.',
    'SETTINGS_CUSTOMIZE_LANGUAGE_FIELD'                 => 'Select language:',
    'SETTINGS_CUSTOMIZE_APPEARANCE'                     => 'Appearance',
    'SETTINGS_CUSTOMIZE_APPEARANCE_THEME_FIELD'         => 'Theme:',
    'SETTINGS_CUSTOMIZE_APPEARANCE_THEME_COLOR_FIELD'   => 'Theme color:',
    'SETTINGS_CUSTOMIZE_APPEARANCE_THEME_DARK'          => 'Dark',
    'SETTINGS_CUSTOMIZE_APPEARANCE_THEME_LIGHT'         => 'Light',
    'SETTINGS_CUSTOMIZE_RESET_TITLE'                    => 'Reset',
    'SETTINGS_CUSTOMIZE_RESET_BUTTON'                   => 'Reset my settings',
    'SETTINGS_CUSTOMIZE_RESET_TEXT'                     => 'Reset the current user\'s settings to defauts.',
    'SETTINGS_CUSTOMIZE_RESET_DIALOG'                   => 'Your settings will be reset to defaults value. Do you want to continue ?',

    /* settings profile */
    'SETTINGS_PROFILE'                                  => 'My account',
    'SETTINGS_PROFILE_SUMMARY'                          => "Edit your user account",
    'SETTINGS_PROFILE_NAME_FIELD'                       => "User name:",
    'SETTINGS_PROFILE_EMAIL_FIELD'                      => "Email address:",
    'SETTINGS_PROFILE_EMAIL_PLACEHOLDER'                => "Enter you email address",
    'SETTINGS_PROFILE_CARD_TITLE'                       => "Overview",
    'SETTINGS_PROFILE_EDIT_TITLE'                       => 'Profile',
    'SETTINGS_PROFILE_EDIT_NAME_OR_EMAIL_BUTTON'        => 'Update profile',
    'SETTINGS_PROFILE_EDIT_PASS_TITLE'                  => "Change password",
    'SETTINGS_PROFILE_EDIT_PASS_CURRENT'                => 'Enter current password:',
    'SETTINGS_PROFILE_EDIT_PASS_NEW'                    => 'New password (min. 8 characters):',
    'SETTINGS_PROFILE_EDIT_PASS_NEW_REPEAT'             => 'Repeat new password:',
    'SETTINGS_PROFILE_EDIT_PASS_BUTTON'                 => 'Update password',
    'SETTINGS_PROFILE_EDIT_AVATAR_TITLE'                => "Change avatar",
    'SETTINGS_PROFILE_EDIT_AVATAR_TEXT'                 => "Select an avatar image (.jpg or .png) from your hard-disk (will be scaled to 90x90 px), then press upload to save changes.",
    'SETTINGS_PROFILE_EDIT_AVATAR_FILE_SELECT'          => "Select file...",
    'SETTINGS_PROFILE_EDIT_AVATAR_BUTTON'               => "Upload",
    'SETTINGS_PROFILE_DELETE_AVATAR_TITLE'              => "Remove avatar",
    'SETTINGS_PROFILE_DELETE_AVATAR_TEXT'               => "Remove avatar file from server and use default avatar image.",
    'SETTINGS_PROFILE_DELETE_AVATAR_BUTTON'             => "Delete avatar",




    'SETTINGS_PROFILE_ACCOUNT_TYPE_FIELD'               => "Account type:",

    'SETTINGS_ABOUT'                                    => 'About', 

    'SETTINGS_INFOS'                                    => 'About',
    'SETTINGS_INFOS_TITLE'                              => 'About',
    'SETTINGS_INFOS_SUMMARY'                            => "Informations about this application",
    'SETTINGS_INFOS_DEPENDENCIES'                       => 'Installed dependencies',
    'DEPENDENCY_LIBRARY'                                => 'Library',
    'DEPENDENCY_VERSION'                                => 'Version',

    'SETTINGS_DATA'                                  => 'Data',
    'SETTINGS_DATA_SUMMARY'                          => "Application data",

    'SETTINGS_USERS'                                    => 'Users',
    'SETTINGS_USERS_SUMMARY'                            => "Create or edit user accounts",
    'SETTINGS_USERS_SECTION_CURRENT_ACCOUNTS'           => 'Currents accounts',
    'SETTINGS_USERS_SECTION_NEW_ACCOUNTS'               => 'New accounts',
    'SETTINGS_USERS_CREATE_ACCOUNT_BUTTON'              => 'Create an account',
    'SETTINGS_USERS_CREATE_ACCOUNT_TEXT'                => 'Creates and activates a new account',
    'SETTINGS_USERS_INVITE_BUTTON'                      => 'Send an invitation',
    'SETTINGS_USERS_INVITE_TEXT'                        => "Sends an invitation to register by email. User will be asked to complete it's profile.",

    'SETTINGS_LOGREADER'                                => 'Logs reader',
    'SETTINGS_LOGREADER_SUMMARY'                        => "Settings for logs reader feature",
    'SETTINGS_LOGREADER_LIST_TITLE'                     => "Registered log files",
    'SETTINGS_LOGREADER_DIALOG_CREATE_TITLE'            => "Add a new log file",
    'SETTINGS_LOGREADER_DIALOG_EDIT_TITLE'              => "Edit log file",
    'SETTINGS_LOGREADER_ACTION_HEADER'                  => "Actions",
    'SETTINGS_LOGREADER_NAME_HEADER'                    => "Name",
    'SETTINGS_LOGREADER_NAME_FIELD'                     => "Name:",
    'SETTINGS_LOGREADER_PATH_FIELD'                     => "Path:",
    'SETTINGS_LOGREADER_PATH_HEADER'                    => "Path",
    'SETTINGS_LOGREADER_TYPE_FIELD'                     => "Type:",
    'SETTINGS_LOGREADER_TYPE_HEADER'                    => "Type",
    'SETTINGS_LOGREADER_FORMAT_HEADER'                  => "Format",
    'SETTINGS_LOGREADER_FORMAT_FIELD'                   => "Format:",
    'SETTINGS_LOGREADER_FORMAT_PLACEHOLDER'             => "Format (leave blank to use default)",
    'SETTINGS_LOGREADER_BUTTON_ADD'                     => "Add",
    'SETTINGS_LOGREADER_ADVANCED'                       => "Advanced",
    'SETTINGS_LOGREADER_IP_ACTION_TEXT'                 => "Select an action for IP addresses (works on web access log files):",
    'SETTINGS_LOGREADER_IP_ACTION_NONE'                 => "None",
    'SETTINGS_LOGREADER_IP_ACTION_ABUSEIPDB'            => "AbuseIPDB check (external link)",
    'SETTINGS_LOGREADER_IP_ACTION_GEOIP'                => "Geodatatool (external link)",
    
    'SETTINGS_SERVICES'                              => 'Services',
    'SETTINGS_SERVICES_SUMMARY'                      => "Add or change services to check",
   
    'SETTINGS_BANS'                                     => 'Parefeu',
    'SETTINGS_BANS_SUMMARY'                             => "Fail2Ban and abuseIPDB API settings",

);