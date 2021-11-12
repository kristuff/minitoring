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
 * @version    0.1.20
 * @copyright  2017-2021 Kristuff
 */

/**
 * Texts used in the application.
 */
return array(

    'HOME'                                              => 'Home',

    /* formats */
    'DATE_FORMAT'                                       => 'Y-m-d',
    'DATE_TIME_FORMAT'                                  => 'Y-m-d H:i:s',
 
    /* app errors */
    'ERROR_UNEXPECTED'                                  => 'An unexpected error occurred',
    'ERROR_PATH_MISSING'                                => "Path '%s' does not exist",
    'ERROR_PATH_PERMISSIONS'                            => "Path '%s' is not writable (invalid permissions)",
    'ERROR_LOGFILE_NOT_FOUND'                           => "The file '%s' was not found.",
    'ERROR_LOGFILE_NOT_READABLE'                        => "The file '%s' is not readable (invalid permissions).",
    'ERROR_LOGFILE_WRONG_TYPE'                          => "The specified type '%s' is not a valid log type.",
    'ERROR_LOGNAME_ALREADY_EXISTS'                      => "A log with same name already exists. Please choose another name.",
    'ERROR_LOGNAME_EMPTY'                               => "You must set a log name.",
    'ERROR_SERVICE_NAME_ALREADY_EXISTS'                 => "A service with same name already exists. Please choose another name.",
    'ERROR_SERVICE_NAME_EMPTY'                          => "You must set a service name.",
    'ERROR_PING_HOST_ALREADY_EXISTS'                    => "This domain already exists. Please set another one.",
    'ERROR_PING_HOST_EMPTY'                             => "You must set a host name.",

    /* UI */
    'BUTTON_OK'                                         => "OK",
    'BUTTON_CANCEL'                                     => "Cancel",
    'THEME_DARK'                                        => 'Dark',
    'THEME_DARK_BLUE'                                   => 'Dark blue',
    'THEME_LIGHT'                                       => 'Light',
    'COLOR_YELLOW'                                      => 'Yellow',
    'COLOR_RED'                                         => 'Red',
    'COLOR_GREEN'                                       => 'Green',
    'COLOR_BLUE'                                        => 'Blue',
    'COLOR_MAGENTA'                                     => 'Magenta',
    'COLOR_ORANGE'                                      => 'Orange',

    /* common */
    'FIELD_ENDING'                                      => ':',
    'ACTION_DELETE'                                     => 'Delete',
    'ACTION_EDIT'                                       => 'Edit',
    'ACTION_REFRESH'                                    => 'Refresh',
    'ACTION_SEARCH'                                     => 'Search',
    'FREE'                                              => "Free",
    'USED'                                              => "Used",
    'PERCENT_USED'                                      => "% used",
    'TOTAL'                                             => "Total",
    'NEXT'                                              => "Next",
    'PREV'                                              => "Back",

    /* user */
    'USER_NAME_FIELD'                                   => "Username:",
    'USER_NAME_PLACEHOLDER'                             => "Username",
    'USER_NAME_CREATE_PLACEHOLDER'                      => "Username (letters/numbers, 2-64 chars)",
    'USER_EMAIL_FIELD'                                  => "Email address:",
    'USER_EMAIL_PLACEHOLDER'                            => "Email address",
    'USER_NAME_OR_EMAIL_FIELD'                          => "User name or email:",
    'USER_NAME_OR_EMAIL_PLACEHOLDER'                    => "User name or email",
    'USER_PASSWORD_FIELD'                               => 'Password:',
    'USER_NEW_PASSWORD_FIELD'                           => 'New password:',
    'USER_PASSWORD_PLACEHOLDER'                         => 'Password',
    'USER_PASSWORD_CREATE_PLACEHOLDER'                  => "Password (min 8 characters)",
    'USER_PASSWORD_REPEAT_FIELD'                        => 'Repeat password: :',
    'USER_PASSWORD_REPEAT_PLACEHOLDER'                  => 'Repeat password',
    'USER_AVATAR_HEADER'                                => "Avatar",
    'USER_NAME_HEADER'                                  => "Username",
    'USER_TYPE_HEADER'                                  => "Type",
    'USER_EMAIL_HEADER'                                 => "Email",
    'USER_STATUS_HEADER'                                => "Status",
    'USER_CREATED_DATE_HEADER'                          => "Created on",
    'USER_LAST_LOGIN_DATE_HEADER'                       => "Last login",

    /* auth */
    'AUTH_LOGIN_REMEMBER_ME'                            => 'Remember me',
    'AUTH_LOGIN_BUTTON_TEXT'                            => 'Log in',
    'AUTH_LOGOUT_BUTTON_TEXT'                           => 'Log out ',
    'AUTH_FORGOT_PASSWORD_LINK'                         => 'Forgot password?',
    'AUTH_RECOVERY_BACK_TO_LOGIN'                       => "Back to login",
    'CAPTCHA_RELOAD_LINK'                               => "Reload captcha",
    'CAPTCHA_FIELD'                                     => "Captcha:",
    'CAPTCHA_PLACEHOLDER'                               => "Enter captcha above",
    'AUTH_REGISTER_BUTTON'                              => "Register",
    'AUTH_REGISTER_TITLE'                               => "Set your user name and password to complete your registration.",
    'AUTH_RECOVERY_SUBMIT_PASSWORD'                     => 'Submit new password',
    'AUTH_RECOVERY_TITLE'                               => "Request a password reset",
    'AUTH_RECOVERY_TEXT'                                => "Enter your username or email and you'll get a mail with instructions.", 
    'AUTH_RECOVERY_BUTTON'                              => "Send me a password-reset mail", 

    /* Overview */
    'OVERVIEW'                                          => 'Overview',

    /* General */
    'GENERAL'                                           => "General",
    'HOSTNAME'                                          => 'Hostname',
    'OS'                                                => 'Operating system',
    'KERNEL_VERSION'                                    => "Kernel version",
    'UPTIME'                                            => "Uptime",
    'LAST_BOOT'                                         => "Last boot",
    'SERVER_DATE'                                       => "Server date and time",

    /* CPU */
    'CPU'                                               => "Cpu",
    'MODEL'                                             => "Model",
    'CORES'                                             => "Cores",
    'SPEED'                                             => "Speed",
    'CACHE'                                             => "Cache",
    'BOGOMIPS'                                          => "BogoMips",
    'TEMPERATURE'                                       => "Temperature",

    /* Sysusers */
    'SYS_USERS'                                         => 'Users',
    'SYS_USERS_CONNECTED'                               => 'Connected user(s)',

    /* Services */
    'SERVICES'                                          => 'Services',

     /* Network */
    'NETWORK'                                           => 'Network',
    'NETWORK_INTERFACE'                                 => 'Interface',
    'NETWORK_RECEIVED'                                  => 'Received',
    'NETWORK_TRANSMITTED'                               => 'Transmitted',

    /* Disks */
    'DISKS'                                             => 'Disks',
    'INODES'                                            => "Inodes",
    'DISK_SPACE'                                        => "Disk space",
    'DISK_FILESYSTEM'                                   => "File system",
    'DISK_TYPE'                                         => "Type",
    'DISK_MOUNT'                                        => "Mount",

    /* Packages */
    'PACKAGES'                                          => 'Packages',
    'PACKAGES_UPGRADE_NONE'                             => 'All packages are up do date',
    'PACKAGES_TOTAL'                                    => 'Total',
    'PACKAGES_INSTALLED'                                => 'Installed',
    'PACKAGES_UPGRADABLE'                               => 'Upgradable',
    'PACKAGES_ERROR'                                    => 'Error',
  
    /* Process */
    'PROCESS'                                           => 'Process',
    'PROCESS_TOTAL'                                     => 'Total',
    'PROCESS_RUNNING'                                   => 'Running',

    /* Logs */
    'LOGS'                                              => 'Logs',
    'LOGS_REFRESH_NONE'                                 => 'No refresh',
    'LOGS_REFRESH_XSECONDS'                             => 'Refresh each %ss',
    'LOGS_DISPLAY_XLINES'                               => 'Display %s lines',

    /* Crons */
    'CRONS'                                             => "Scheduled tasks",
    'CRONS_USER'                                        => "User cron jobs",
    'CRONS_SYSTEM'                                      => "System cron jobs",
    'CRONS_TIMER'                                       => "System timers",
    'CRONS_USER_HEADER'                                 => "User",
    'CRONS_TIME_HEADER'                                 => "Time Expression",
    'CRONS_COMMAND_HEADER'                              => "Command",
    'CRONS_NEXT_TIME_HEADER'                            => "Next Run date",
    'CRONS_SCRIPT_HEADER'                               => "Script",
    'CRONS_TYPE_HEADER'                                 => "Type",

    /* firewall */
    'FIREWALL'                                          => 'Firewall',
    'FAIL2BAN_TEXT'                                     => 'Check Fail2ban status and get jails stats and status',
    'IPTABLES_TEXT'                                     => 'Get iptables content',
    'IP6TABLES_TEXT'                                    => 'Get ip6tables content',

    /* settings */
    'SETTINGS'                                          => 'Settings',
    'ERROR_DELETE_APP_TOKEN_FILE'                       => 'Enable to delete token file.',

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
    'SETTINGS_PROFILE_NAME_PLACEHOLDER'                 => "Enter your user name",
    'SETTINGS_PROFILE_EMAIL_FIELD'                      => "Email address:",
    'SETTINGS_PROFILE_EMAIL_PLACEHOLDER'                => "Enter your email address",
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
    //'SETTINGS_PROFILE_ACCOUNT_TYPE_FIELD'               => "Account type:",

    /* settings about */
    'SETTINGS_INFOS'                                    => 'About',
    'SETTINGS_INFOS_TITLE'                              => 'About',
    'SETTINGS_INFOS_SUMMARY'                            => "Informations about this application",
    'SETTINGS_INFOS_DEPENDENCIES'                       => 'Installed dependencies',
    'DEPENDENCY_LIBRARY'                                => 'Library',
    'DEPENDENCY_VERSION'                                => 'Version',

    //'SETTINGS_DATA'                                  => 'Data',
    //'SETTINGS_DATA_SUMMARY'                          => "Application data",

    /* settings users */
    'SETTINGS_USERS'                                    => 'Users',
    'SETTINGS_USERS_SUMMARY'                            => "Create or edit user accounts",
    'SETTINGS_USERS_SECTION_CURRENT_ACCOUNTS'           => 'Currents accounts',
    'SETTINGS_USERS_SECTION_NEW_ACCOUNTS'               => 'New accounts',
    'SETTINGS_USERS_CREATE_ACCOUNT_DIALOG_TITLE'        => 'Create a new account',
    'SETTINGS_USERS_CREATE_ACCOUNT_BUTTON'              => 'New account',
    'SETTINGS_USERS_CREATE_ACCOUNT_TEXT'                => 'Creates and activates a new account',
    'SETTINGS_USERS_INVITE_BUTTON'                      => 'Send an invitation',
    'SETTINGS_USERS_INVITE_TEXT'                        => "Sends an invitation to register by email. User will be asked to complete it's profile.",
    'SETTINGS_USERS_FULL_DELETE_TEXT'                   => "This will delete user and setting from database. This action cannot be canceled.",
    'SETTINGS_USERS_INVITE_DIALOG_TITLE'                => "Invite a user",
    'SETTINGS_USERS_INVITE_DIALOG_MAIL_FIELD'           => "Send an invitation by email to:",

    /* settings services */
    'SETTINGS_SERVICES'                                 => 'Services',
    'SETTINGS_SERVICES_SUMMARY'                         => "Add or change services to check",
    'SETTINGS_SERVICES_REGISTERED_TITLE'                => 'Registered services',
    'SETTINGS_SERVICES_DIALOG_CREATE_TITLE'             => "Add a service",
    'SETTINGS_SERVICES_DIALOG_EDIT_TITLE'               => "Edit service",
    'SETTINGS_SERVICES_BUTTON_ADD'                      => "Add",
    'SETTINGS_SERVICES_DELETE_MESSAGE'                  => "This will remove the service and checks history. This action cannot be canceled.",
    'SETTINGS_SERVICES_PROTOCOL_FIELD'                  => "Protocol:",
    'SETTINGS_SERVICES_PROTOCOL_HEADER'                 => "Protocol",
    'SETTINGS_SERVICES_NAME_FIELD'                      => "Name:",
    'SETTINGS_SERVICES_NAME_HEADER'                     => "Service",
    'SETTINGS_SERVICES_NAME_PLACEHOLDER'                => "Display name",
    'SETTINGS_SERVICES_HOST_FIELD'                      => "Host:",
    'SETTINGS_SERVICES_HOST_HEADER'                     => "Host",
    'SETTINGS_SERVICES_HOST_PLACEHOLDER'                => "Host (ex. localhost)",
    'SETTINGS_SERVICES_PORT_FIELD'                      => "Port :",
    'SETTINGS_SERVICES_PORT_HEADER'                     => "Port",
    'SETTINGS_SERVICES_PORT_PLACEHOLDER'                => "Port",
    'SETTINGS_SERVICES_CHECK_ENABLED_HEADER'            => "Check enabled",

    /* settings ping */
    'SETTINGS_PING'                                     => 'Ping',
    'SETTINGS_PING_SUMMARY'                             => "Add or change hosts to check",
    'SETTINGS_PING_REGISTERED_TITLE'                    => 'Registered hosts',
    'SETTINGS_PING_DIALOG_CREATE_TITLE'                 => "New host",
    'SETTINGS_PING_DIALOG_EDIT_TITLE'                   => "Edit host",
    'SETTINGS_PING_BUTTON_ADD'                          => "Add",
    'SETTINGS_PING_HOST'                                => "Host",
    'SETTINGS_PING_CHECK_ENABLED_HEADER'                => "Check enabled",

    /* settings logreader */
    'SETTINGS_LOGREADER'                                => 'Logs reader',
    'SETTINGS_LOGREADER_SUMMARY'                        => "Settings for logs reader feature",
    'SETTINGS_LOGREADER_LIST_TITLE'                     => "Registered log files",
    'SETTINGS_LOGREADER_DIALOG_CREATE_TITLE'            => "Add a log file",
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
    'SETTINGS_LOGREADER_FORMAT_PLACEHOLDER'             => "Select a predefined format above or enter custom format",
    'SETTINGS_LOGREADER_BUTTON_ADD'                     => "Add",
   
    /* settings advanced */
    'SETTINGS_ADVANCED'                                 => 'Advanced', 
    'SETTINGS_ADVANCED_SUMMARY'                         => 'Advanced parameters', 
    'SETTINGS_SECURITY_TITLE'                           => "Security",
    'SETTINGS_TOKEN_FIELD'                              => "Current token:",
    'SETTINGS_TOKEN_TEXT'                               => "The application uses a key to verify that the author of the requests to the WebSocket API is an authorized user. A not logged in user who has the key could obtain information via this API. If you believe this key is compromised, you can regenerate it.",
    'SETTINGS_TOKEN_RESET_BUTTON'                       => "Create new token",
    'SETTINGS_MISC_TITLE'                               => "Miscellaneous",
    'SETTINGS_IP_ACTION_FIELD'                          => "Select an action for IP addresses (works on web access log files):",
    'SETTINGS_IP_ACTION_NONE'                           => "None",
    'SETTINGS_IP_ACTION_ABUSEIPDB'                      => "AbuseIPDB check (external link)",
    'SETTINGS_IP_ACTION_GEOIP'                          => "Geodatatool (external link)",
    'SETTINGS_SERVICES_SHOW_PORT_NUMBER'                => "Show port number",
    'SETTINGS_DISK_SHOW_TMPFS'                          => "Show tmpf",
    'SETTINGS_DISK_SHOW_LOOP'                           => "Show loop",
    'SETTINGS_DISK_SHOW_FILE_SYSTEM'                    => "Show file system",
    'SETTINGS_CPU_SHOW_TEMPERATURE'                     => "Show temperature (may require additional packages like lm-sensors on Debian based distros).",
    'SETTINGS_DEFAULT_TITLE'                            => 'Default settings',
    'SETTINGS_DEFAULT_TEXT'                             => "Define default settings. Apply to login/recovery pages",

    /* setup */
    'SETUP_TITLE'                                       => "Minitoring installer",
    'SETUP_SELECT_LANG'                                 => "Select your language:",
    'SETUP_INTRO_1'                                     => "Application is not configured. This program allows to create a database for your application.",
    'SETUP_INTRO_2'                                     => "Press 'Next' to start the installer.",
    'SETUP_CHECK_TITLE'                                 => "Requirements and permissions check",
    'SETUP_CHECK_SUCCESSFULL'                           => "Fine, all checks passed.",
    'SETUP_CHECK_HAS_ERROR'                             => "Please fix error(s) bellow before continue:",
    'SETUP_ERROR_DATABASE_EXISTS'                       => "A database with same name already exists. Please choose another database name.",
    'SETUP_ERROR_CREATE_DATABASE'                       => "Internal error: unable to create database.",
    'SETUP_ERROR_CREATE_TABLES'                         => "Internal error: unable to create tables.",
    'SETUP_ERROR_CREATE_ADMIN_USER'                     => "Internal error: unable to insert admin user.",
    'SETUP_ERROR_CREATE_LOAD_APP_SETTINGS'              => "Internal error: unable to insert app settings data in database.",
    'SETUP_ERROR_CREATE_LOAD_USER_SETTINGS'             => "Internal error: unable to insert user settings data in database.",
    'SETUP_ERROR_CREATE_CONF_FILE'                      => "Internal error: unable to create config file.",
    'SETUP_DB_CONF_TITLE_1'                             => "Configure database (1/2)",
    'SETUP_DB_CONF_TITLE_2'                             => "Configure database (2/2)",
    'SETUP_DB_CONF_SELECT_TYPE'                         => "Select database type:",
    'SETUP_DB_CONF_SERVER_IDENT_TEXT'                   => "Please enter your server credentials.",
    'SETUP_DB_SET_NAME_NO_USER_TEXT'                    => "Choose a name for the database.",
    'SETUP_DB_SET_NAME_WITH_SUSER_TEXT'                 => "Choose a username and password for the database.",
    'SETUP_SET_ADMIN_ACCOUNT_TITLE'                     => "Add admin account",
    'SETUP_SET_ADMIN_ACCOUNT_TEXT'                      => "Please set admin user credentials.", 
    'SETUP_WIZARD_BUTTON_CLOSE'                         => "Close",
    'SETUP_WIZARD_BUTTON_INSTALL'                       => "Install",
    'SETUP_INSTALL_SUCCESSFULL'                         => "Congratulation! <br>Install was successful. You can now login.",
    'SETUP_TERMINATE_TITLE'                             => "Complete install",
    'SETUP_TERMINATE_MESSAGE'                           => "Press 'Install' to start the installation.",
    'SETUP_TERMINATE_WARNING'                           => "The setup will take a few moments. <br> Make sure to maintain the connection during install.",
    'SQL_HOST_FIELD'                                    => "Database host:",
    'SQL_HOST_PLACEHOLDER'                              => "Database host (ex. localhost)",
    'SQL_ADMIN_NAME_FIELD'                              => "Admin name:",
    'SQL_ADMIN_NAME_PLACEHOLDER'                        => "Admin name (ex. root)",
    'SQL_ADMIN_PASSWORD_FIELD'                          => "Admin password:",
    'SQL_ADMIN_PASSWORD_PLACEHOLDER'                    => "Admin password",
    'DB_NAME_FIELD'                                     => "Database name:",
    'DB_NAME_PLACEHOLDER'                               => "Database name",
    'DB_USER_NAME_FIELD'                                => "Database user name:",
    'DB_USER_NAME_PLACEHOLDER'                          => "Database user name",
    'DB_USER_PASSWORD_FIELD'                            => "Database password:",
    'DB_USER_PASSWORD_PLACEHOLDER'                      => "Database password",
    'DB_ADMIN_NAME_FIELD'                               => "Admin name:",
    'DB_ADMIN_NAME_PLACEHOLDER'                         => "Admin name",
    'DB_ADMIN_PASSWORD_FIELD'                           => "Admin password:",
    'DB_ADMIN_PASSWORD_PLACEHOLDER'                     => "Admin password",
    'DB_ADMIN_EMAIL_FIELD'                              => "Admin email address:",
    'DB_ADMIN_EMAIL_PLACEHOLDER'                        => "Admin email address",

);