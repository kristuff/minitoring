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

/**
 * Texts used in the application.
 */
return array(

    'HOME'                                              => 'Accueil',

    /* formats */
    'DATE_FORMAT'                                       => 'd/m/Y',
    'DATE_TIME_FORMAT'                                  => 'd/m/Y H:i:s',

    /* app errors */
    'ERROR_UNEXPECTED'                                  => 'Une erreur inconnue est survenue.',
    'ERROR_PATH_MISSING'                                => "Le répertoire '%s' est introuvable",
    'ERROR_PATH_PERMISSIONS'                            => "Le répertoire '%s' n'est pas accessible en écriture (mauvaises permissions).",
    'ERROR_LOGFILE_NOT_FOUND'                           => "Le fichier '%s' est introuvable.",
    'ERROR_LOGFILE_NOT_READABLE'                        => "Le fichier '%s' n'est pas accessible en lecture (mauvaises permissions).",
    'ERROR_LOGFILE_WRONG_TYPE'                          => "Le type spécifié '%s' n'est pas un type de log valide.",
    'ERROR_LOGNAME_ALREADY_EXISTS'                      => "Un journal avec le même nom existe déja. Veuillez choisir un autre nom.",
    'ERROR_LOGNAME_EMPTY'                               => "Vous devez définir un nom de journal.",
    'ERROR_SERVICE_NAME_ALREADY_EXISTS'                 => "Un service avec le même nom existe déja. Veuillez choisir un autre nom.",
    'ERROR_SERVICE_NAME_EMPTY'                          => "Vous devez définir un nom de service.",
    'ERROR_PING_HOST_ALREADY_EXISTS'                    => "Ce domaine existe déja. Veuillez entrer un autre domaine.",
    'ERROR_PING_HOST_EMPTY'                             => "Vous devez définir un nom de domaine.",

    /* UI */
    'BUTTON_OK'                                         => "OK",
    'BUTTON_CANCEL'                                     => "Annuler",
    'THEME_DARK'                                        => 'Foncé',
    'THEME_DARK_BLUE'                                   => 'Foncé (bleu)',
    'THEME_LIGHT'                                       => 'Clair',
    'COLOR_YELLOW'                                      => 'Jaune',
    'COLOR_RED'                                         => 'Rouge',
    'COLOR_GREEN'                                       => 'Vert',
    'COLOR_BLUE'                                        => 'Bleu',
    'COLOR_MAGENTA'                                     => 'Violet',
    'COLOR_ORANGE'                                      => 'Orange',

    /* common */
    'FIELD_ENDING'                                      => ' :',
    'ACTION_DELETE'                                     => 'Supprimer',
    'ACTION_EDIT'                                       => 'Modifier',
    'ACTION_REFRESH'                                    => 'Rafraîchir',
    'ACTION_SEARCH'                                     => 'Rechercher',
    'FREE'                                              => "Libre",
    'USED'                                              => "Utilisé",
    'PERCENT_USED'                                      => "% utilisé",
    'TOTAL'                                             => "Total",
    'NEXT'                                              => "Suivant",
    'PREV'                                              => "Précédent",

    /* user */
    'USER_NAME_FIELD'                                   => "Nom d'utilisateur :",
    'USER_NAME_PLACEHOLDER'                             => "Entrez votre nom d'utilisateur",
    'USER_NAME_CREATE_PLACEHOLDER'                      => "Nom d'utilisateur (lettres/nombres, 2-64 caractères)",
    'USER_EMAIL_FIELD'                                  => "Adresse email :",
    'USER_EMAIL_PLACEHOLDER'                            => "Adresse email",
    'USER_NAME_OR_EMAIL_FIELD'                          => "Nom d'utilisateur ou adresse email :",
    'USER_NAME_OR_EMAIL_PLACEHOLDER'                    => "Nom d'utilisateur ou adresse email",
    'USER_PASSWORD_FIELD'                               => 'Mot de passe :',
    'USER_NEW_PASSWORD_FIELD'                           => 'Nouveau mot de passe :',
    'USER_PASSWORD_PLACEHOLDER'                         => 'Mot de passe',
    'USER_PASSWORD_CREATE_PLACEHOLDER'                  => "Mot de passe (min. 8 caractères)",
    'USER_PASSWORD_REPEAT_FIELD'                        => 'Répétez le mot de passe :',
    'USER_PASSWORD_REPEAT_PLACEHOLDER'                  => 'Mot de passe',
    'USER_AVATAR_HEADER'                                => "Avatar",
    'USER_NAME_HEADER'                                  => "Nom",
    'USER_TYPE_HEADER'                                  => "Type",
    'USER_EMAIL_HEADER'                                 => "Email",
    'USER_STATUS_HEADER'                                => "Status",
    'USER_CREATED_DATE_HEADER'                          => "Créé le",
    'USER_LAST_LOGIN_DATE_HEADER'                       => "Dernière connexion",

    /* login */
    'AUTH_LOGIN_REMEMBER_ME'                            => 'Rester connecté',
    'AUTH_LOGIN_BUTTON_TEXT'                            => 'Se connecter',
    'AUTH_LOGOUT_BUTTON_TEXT'                           => 'Déconnexion',
    'AUTH_FORGOT_PASSWORD_LINK'                         => 'Mot de passe oublié ?',
    'AUTH_RECOVERY_BACK_TO_LOGIN'                       => "Retourner à la page de connexion",
    'CAPTCHA_RELOAD_LINK'                               => "Recharger l'image",
    'CAPTCHA_FIELD'                                     => "Code de sécurité :",
    'CAPTCHA_PLACEHOLDER'                               => "Entrez le code de sécurité",
    'AUTH_REGISTER_BUTTON'                              => "S'enregistrer",
    'AUTH_REGISTER_TITLE'                               => "Veuillez définir votre nom d'utilisateur et votre mot de passe pour terminer votre inscription.",
    'AUTH_RECOVERY_SUBMIT_PASSWORD'                     => 'Changer le mot de passe',
    'AUTH_RECOVERY_TITLE'                               => "Demander une récupération de mot de passe",
    'AUTH_RECOVERY_TEXT'                                => "Entrez votre nom d'utilisateur ou votre adresse email et nous vous enverrons un email avec des instructions.", 
    'AUTH_RECOVERY_BUTTON'                              => "Envoyer un mail de récupération", 

    /* Overview */
    'OVERVIEW'                                          => "Vue d'ensemble",

    /* General */
    'GENERAL'                                           => "Général",
    'HOSTNAME'                                          => "Nom d'hôte",
    'OS'                                                => "Système d'exploitation",
    'KERNEL_VERSION'                                    => "Version du noyau",
    'UPTIME'                                            => "Durée de fonctionnement",
    'LAST_BOOT'                                         => "Dernier démarrage",
    'SERVER_DATE'                                       => "Date du serveur",

    /* CPU */
    'CPU'                                               => "Processeur",
    'MODEL'                                             => "Modèle",
    'CORES'                                             => "Cœurs",
    'SPEED'                                             => "Vitesse",
    'CACHE'                                             => "Cache",
    'BOGOMIPS'                                          => "BogoMips",
    'TEMPERATURE'                                       => "Température",

    /* Sysusers */
    'SYS_USERS'                                         => 'Utilisateurs',
    'SYS_USERS_CONNECTED'                               => 'Utilisateur(s) connecté(s)',

    /* Services */
    'SERVICES'                                          => 'Services',

    /* Network */
    'NETWORK'                                           => 'Réseau',
    'NETWORK_INTERFACE'                                 => 'Interface',
    'NETWORK_RECEIVED'                                  => 'Reçu',
    'NETWORK_TRANSMITTED'                               => 'Transmis',

    /* Disks */
    'DISKS'                                             => 'Disques',
    'INODES'                                            => "Nœuds d'index (inodes)",
    'DISK_SPACE'                                        => "Espace disque",
    'DISK_FILESYSTEM'                                   => "Système de fichier",
    'DISK_TYPE'                                         => "Type",
    'DISK_MOUNT'                                        => "Monté sur",

    /* Packages */
    'PACKAGES'                                          => 'Paquets',
    'PACKAGES_UPGRADE_NONE'                             => 'Tous les paquets sont à jour',
    'PACKAGES_TOTAL'                                    => 'Total',
    'PACKAGES_INSTALLED'                                => 'Installés',
    'PACKAGES_UPGRADABLE'                               => 'Mises à jour disponibles',
    'PACKAGES_ERROR'                                    => 'Erreurs',
 
    /* Process */
    'PROCESS'                                           => 'Processus',
    'PROCESS_TOTAL'                                     => 'Total',
    'PROCESS_RUNNING'                                   => 'En cours',

    /* Logs */
    'LOGS'                                              => 'Journaux',
    'LOGS_REFRESH_NONE'                                 => 'Ne pas rafraîchir',
    'LOGS_REFRESH_XSECONDS'                             => 'Rafraîchir toutes les %ss',
    'LOGS_DISPLAY_XLINES'                               => 'Afficher %s lignes',
    'LOGS_LOAD_MORE_BUTTON'                             => 'Charger plus de lignes...',

    /* Crons */
    'CRONS'                                             => "Tâches planifiées",
    'CRONS_USER'                                        => "Tâches utilisateurs (crons)",
    'CRONS_SYSTEM'                                      => "Tâches système (crons)",
    'CRONS_TIMER'                                       => "Tâches système (timers)",
    'CRONS_USER_HEADER'                                 => "Utilisateur",
    'CRONS_TIME_HEADER'                                 => "Expression",
    'CRONS_COMMAND_HEADER'                              => "Commande",
    'CRONS_NEXT_TIME_HEADER'                            => "Prochaine exécution",
    'CRONS_SCRIPT_HEADER'                               => "Script",
    'CRONS_TYPE_HEADER'                                 => "Type",

    /* firewall */
    'FIREWALL'                                          => 'Pare-feu',
    'FAIL2BAN_TEXT'                                     => 'Vérifie le status du service Fail2ban et affiche des statistiques sur les jails',
    'IPTABLES_TEXT'                                     => "Affiche le contenu d'iptables",
    'IP6TABLES_TEXT'                                    => "Affiche le contenu d'ip6tables",

    /* settings */
    'SETTINGS'                                          => 'Paramètres',
    'ERROR_DELETE_APP_TOKEN_FILE'                       => 'Impossible de supprimer le fichier de clé.',

    /* settings customize */
    'SETTINGS_CUSTOMIZE'                                => 'Personnaliser',
    'SETTINGS_CUSTOMIZE_SUMMARY'                        => "Changer la langue, l'apparence et l'affichage par défaut",
    'SETTINGS_CUSTOMIZE_LANGUAGE'                       => 'Langue',
    'SETTINGS_CUSTOMIZE_LANGUAGE_TEXT'                  => 'Vous devez recharger la page pour appliquer les changements de langue.',
    'SETTINGS_CUSTOMIZE_LANGUAGE_FIELD'                 => 'Sélectionnez la langue :',
    'SETTINGS_CUSTOMIZE_APPEARANCE'                     => 'Apparence',
    'SETTINGS_CUSTOMIZE_APPEARANCE_THEME_FIELD'         => 'Thème :',
    'SETTINGS_CUSTOMIZE_APPEARANCE_THEME_COLOR_FIELD'   => 'Couleur d\'accentuation :',
    'SETTINGS_CUSTOMIZE_APPEARANCE_THEME_DARK'          => 'Foncé',
    'SETTINGS_CUSTOMIZE_APPEARANCE_THEME_LIGHT'         => 'Clair',
    'SETTINGS_CUSTOMIZE_RESET_TITLE'                    => 'Remise à zéro',
    'SETTINGS_CUSTOMIZE_RESET_BUTTON'                   => 'Paramètres par défaut',
    'SETTINGS_CUSTOMIZE_RESET_TEXT'                     => 'Recharge les paramètres par défaut.',
    'SETTINGS_CUSTOMIZE_RESET_DIALOG'                   => 'Vos paramètres vont être remis à zéro. Voulez-vous continuer ?',

    /* settings profile */
    'SETTINGS_PROFILE'                                  => 'Mon compte',
    'SETTINGS_PROFILE_SUMMARY'                          => "Modifier votre compte utilisateur",
    'SETTINGS_PROFILE_NAME_FIELD'                       => "Nom d'utilisateur :",
    'SETTINGS_PROFILE_NAME_PLACEHOLDER'                 => "Entrez votre nom d'utilisateur",
    'SETTINGS_PROFILE_EMAIL_FIELD'                      => "Adresse email :",
    'SETTINGS_PROFILE_EMAIL_PLACEHOLDER'                => "Entrez votre adresse email",
    'SETTINGS_PROFILE_CARD_TITLE'                       => "Résumé",
    'SETTINGS_PROFILE_EDIT_TITLE'                       => 'Profil',
    'SETTINGS_PROFILE_EDIT_NAME_OR_EMAIL_BUTTON'        => 'Mettre à jour le profil',
    'SETTINGS_PROFILE_EDIT_PASS_TITLE'                  => "Changer le mot de passe",
    'SETTINGS_PROFILE_EDIT_PASS_CURRENT'                => 'Entrez le mot passe actuel :',
    'SETTINGS_PROFILE_EDIT_PASS_NEW'                    => 'Nouveau mot de passe (min. 8 caractères) :',
    'SETTINGS_PROFILE_EDIT_PASS_NEW_REPEAT'             => 'Répetez le nouveau mot de passe :',
    'SETTINGS_PROFILE_EDIT_PASS_BUTTON'                 => 'Mettre à jour le mot de passe',
    'SETTINGS_PROFILE_EDIT_AVATAR_TITLE'                => "Changer d'avatar",
    'SETTINGS_PROFILE_EDIT_AVATAR_TEXT'                 => "Sélectionnez une image (.jpg or .png) sur votre ordinateur (l'image sera réduite à 90x90 pixels), et appuyez sur envoyer.",
    'SETTINGS_PROFILE_EDIT_AVATAR_FILE_SELECT'          => "Sélectionner un fichier...",
    'SETTINGS_PROFILE_EDIT_AVATAR_BUTTON'               => "Envoyer",
    'SETTINGS_PROFILE_DELETE_AVATAR_TITLE'              => "Supprimer mon avatar",
    'SETTINGS_PROFILE_DELETE_AVATAR_TEXT'               => "Supprime l'avatar du serveur.",
    'SETTINGS_PROFILE_DELETE_AVATAR_BUTTON'             => "Supprimer l'avatar",
    //'SETTINGS_PROFILE_ACCOUNT_TYPE_FIELD'               => "Type de compte :",

    /* settings about */
    'SETTINGS_INFOS'                                    => 'A propos',
    'SETTINGS_INFOS_TITLE'                              => 'A propos',
    'SETTINGS_INFOS_SUMMARY'                            => "Informations sur cette application",
    'SETTINGS_INFOS_DEPENDENCIES'                       => 'Dépendences installées',
    'DEPENDENCY_LIBRARY'                                => 'Bibliothèque',
    'DEPENDENCY_VERSION'                                => 'Version',


    //'SETTINGS_DATA'                                     => 'Données',
    //'SETTINGS_DATA_SUMMARY'                             => "Données de l'application",
    
    /* settings users */
    'SETTINGS_USERS'                                    => 'Utilisateurs',
    'SETTINGS_USERS_SUMMARY'                            => "Créer ou modifier les comptes utilisateurs.",
    'SETTINGS_USERS_SECTION_CURRENT_ACCOUNTS'           => 'Comptes utilisateurs',
    'SETTINGS_USERS_SECTION_NEW_ACCOUNTS'               => 'Nouveaux comptes',
    'SETTINGS_USERS_CREATE_ACCOUNT_DIALOG_TITLE'        => 'Créer un nouveau compte',
    'SETTINGS_USERS_CREATE_ACCOUNT_BUTTON'              => 'Créer un compte',
    'SETTINGS_USERS_CREATE_ACCOUNT_TEXT'                => 'Crée et active un nouveau compte utilisateur.',
    'SETTINGS_USERS_INVITE_BUTTON'                      => 'Envoyer une invitation',
    'SETTINGS_USERS_INVITE_TEXT'                        => "Envoie une invitation à s'enregister par email. L'utilisateur sera invité à compléter son profil.",
    'SETTINGS_USERS_FULL_DELETE_TEXT'                   => "L'utilisateur et ses données seront définitivement supprimés de la base de données. Cette action ne peut pas être annulée. ",
    'SETTINGS_USERS_INVITE_DIALOG_TITLE'                => "Inviter un utilisateur",
    'SETTINGS_USERS_INVITE_DIALOG_MAIL_FIELD'           => "Envoyer une invitation par email à :",

    /* settings services */
    'SETTINGS_SERVICES'                                 => 'Services',
    'SETTINGS_SERVICES_SUMMARY'                         => "Créer ou modifier les services à surveiller",
    'SETTINGS_SERVICES_REGISTERED_TITLE'                => 'Services enregistrés',
    'SETTINGS_SERVICES_DIALOG_CREATE_TITLE'             => "Ajouter un service",
    'SETTINGS_SERVICES_DIALOG_EDIT_TITLE'               => "Modifier le service",
    'SETTINGS_SERVICES_BUTTON_ADD'                      => "Ajouter",
    'SETTINGS_SERVICES_DELETE_MESSAGE'                  => "Cela supprimera le service et l'historique des vérifications. Cette action ne peut pas être annulée.",
    'SETTINGS_SERVICES_PROTOCOL_FIELD'                  => "Protocole :",
    'SETTINGS_SERVICES_PROTOCOL_HEADER'                 => "Protocole",
    'SETTINGS_SERVICES_NAME_FIELD'                      => "Nom :",
    'SETTINGS_SERVICES_NAME_HEADER'                     => "Service",
    'SETTINGS_SERVICES_NAME_PLACEHOLDER'                => "Nom affiché",
    'SETTINGS_SERVICES_HOST_FIELD'                      => "Hôte :",
    'SETTINGS_SERVICES_HOST_HEADER'                     => "Hôte",
    'SETTINGS_SERVICES_HOST_PLACEHOLDER'                => "Hôte (ex. localhost)",
    'SETTINGS_SERVICES_PORT_FIELD'                      => "Port :",
    'SETTINGS_SERVICES_PORT_HEADER'                     => "Port",
    'SETTINGS_SERVICES_PORT_PLACEHOLDER'                => "Port",
    'SETTINGS_SERVICES_CHECK_ENABLED_HEADER'            => "Vérification activée",
    
    /* settings ping */
    'SETTINGS_PING'                                     => 'Ping',
    'SETTINGS_PING_SUMMARY'                             => "Créer ou modifier les domaines à vérifier",
    'SETTINGS_PING_REGISTERED_TITLE'                    => 'Domaines enregistrés',
    'SETTINGS_PING_DIALOG_CREATE_TITLE'                 => "Nouveau domaine",
    'SETTINGS_PING_DIALOG_EDIT_TITLE'                   => "Modifier le domaine",
    'SETTINGS_PING_BUTTON_ADD'                          => "Ajouter",
    'SETTINGS_PING_HOST'                                => "Domaine",
    'SETTINGS_PING_CHECK_ENABLED'                       => "Vérification activée",

    /* settings logreader */
    'SETTINGS_LOGREADER'                                => 'Journaux',
    'SETTINGS_LOGREADER_SUMMARY'                        => "Paramètres du lecteur de journaux",
    'SETTINGS_LOGREADER_LIST_TITLE'                     => "Fichiers journaux enregistrés",
    'SETTINGS_LOGREADER_DIALOG_CREATE_TITLE'            => "Ajouter un fichier journal",
    'SETTINGS_LOGREADER_DIALOG_EDIT_TITLE'              => "Modifier un fichier journal",
    'SETTINGS_LOGREADER_ACTION_HEADER'                  => "Actions",
    'SETTINGS_LOGREADER_NAME_HEADER'                    => "Nom",
    'SETTINGS_LOGREADER_NAME_FIELD'                     => "Nom :",
    'SETTINGS_LOGREADER_PATH_FIELD'                     => "Chemin complet :",
    'SETTINGS_LOGREADER_PATH_HEADER'                    => "Chemin",
    'SETTINGS_LOGREADER_TYPE_FIELD'                     => "Type :",
    'SETTINGS_LOGREADER_TYPE_HEADER'                    => "Type",
    'SETTINGS_LOGREADER_FORMAT_HEADER'                  => "Format",
    'SETTINGS_LOGREADER_FORMAT_FIELD'                   => "Format :",
    'SETTINGS_LOGREADER_FORMAT_PLACEHOLDER'             => "Sélectionnez un format prédéfini ci-dessus ou entrez un format personnalisé",
    'SETTINGS_LOGREADER_BUTTON_ADD'                     => "Ajouter",

    /* settings advanced */
    'SETTINGS_ADVANCED'                                 => 'Avancé', 
    'SETTINGS_ADVANCED_SUMMARY'                         => 'Paramètres avancés', 
    'SETTINGS_SECURITY_TITLE'                           => "Sécurité",
    'SETTINGS_TOKEN_FIELD'                              => "Clé actuelle :",
    'SETTINGS_TOKEN_TEXT'                               => "L'application utilise une clé pour vérifier que l'auteur des requêtes vers l'API WebSocket est un utilisateur autorisé. Un utilisateur non connecté mais disposant de la clé pourrait obtenir des informations via cette API. Si vous pensez que cette clé est compromise, vous pouvez la regénérer.",
    'SETTINGS_TOKEN_RESET_BUTTON'                       => "Créer une nouvelle clé",
    'SETTINGS_MISC_TITLE'                               => "Divers",
    'SETTINGS_IP_ACTION_FIELD'                          => "Sélectionnez une action pour les adresses IP (fonctionne principalement dans les journaux web) :",
    'SETTINGS_IP_ACTION_NONE'                           => "Aucune",
    'SETTINGS_IP_ACTION_ABUSEIPDB'                      => "Vérification sur AbuseIPDB (lien externe)",
    'SETTINGS_IP_ACTION_GEOIP'                          => "Geodatatool (lien externe)",
    'SETTINGS_SERVICES_SHOW_PORT_NUMBER'                => "Afficher le numéro de port",
    'SETTINGS_DISK_SHOW_TMPFS'                          => "Afficher les systèmes de fichiers temporaires (tmpfs)",
    'SETTINGS_DISK_SHOW_LOOP'                           => "Afficher les systèmes de fichiers loop",
    'SETTINGS_DISK_SHOW_FILE_SYSTEM'                    => "Afficher les systèmes de fichiers",
    'SETTINGS_CPU_SHOW_TEMPERATURE'                     => "Afficher la température (peut nécessiter des packages supplémentaires comme lm-sensors sur les distributions basées sur Debian).",
    'SETTINGS_DEFAULT_TITLE'                            => 'Paramètres par défaut',
    'SETTINGS_DEFAULT_TEXT'                             => "Definit les paramètres par défaut. S'applique aux pages de connexion / récupération de mot de passe.",

    /* setup */
    'SETUP_TITLE'                                       => "Installation de Minitoring",
    'SETUP_SELECT_LANG'                                 => "Sélectionnez votre langue :",
    'SETUP_INTRO_1'                                     => "L'application n'est pas configurée. Ce programme permet de créer une base de données pour votre application.",
    'SETUP_INTRO_2'                                     => "Appuyez sur 'Suivant' pour démarrer le programme d'installation.",
    'SETUP_CHECK_TITLE'                                 => "Vérification des droits et des requirements",
    'SETUP_CHECK_SUCCESSFULL'                           => "Toutes les vérifications ont réussi.",
    'SETUP_CHECK_HAS_ERROR'                             => "Veuillez corriger les erreurs suivantes avant de continuer :",
    'SETUP_ERROR_DATABASE_EXISTS'                       => "Une base de données avec le même nom existe déjà à cet emplacament. Veuillez choisir un autre nom.",
    'SETUP_ERROR_CREATE_DATABASE'                       => "Erreur interne : impossible de créer la base de données.",
    'SETUP_ERROR_CREATE_TABLES'                         => "Erreur interne : impossible de créer les tables.",
    'SETUP_ERROR_CREATE_ADMIN_USER'                     => "Erreur interne : impossible d'ajouter l'utilisateur admin.",
    'SETUP_ERROR_CREATE_LOAD_APP_SETTINGS'              => "Erreur interne : impossible d'ajouter les paramètres de l'application dans la base de données.",
    'SETUP_ERROR_CREATE_LOAD_USER_SETTINGS'             => "Erreur interne : impossible d'ajouter les paramètres utilisateurs dans la base de données.",
    'SETUP_ERROR_CREATE_CONF_FILE'                      => "Erreur interne : impossible de créer le fichier de configuration.",
    'SETUP_DB_CONF_TITLE_1'                             => "Configurer la base de données (1/2)",
    'SETUP_DB_CONF_TITLE_2'                             => "Configurer la base de données (2/2)",
    'SETUP_DB_CONF_SELECT_TYPE'                         => "Choisissez le type de base de données :",
    'SETUP_DB_CONF_SERVER_IDENT_TEXT'                   => "Veuillez renseigner vos identifiants serveur.",
    'SETUP_DB_SET_NAME_NO_USER_TEXT'                    => "Choisissez un nom pour la base de données.",
    'SETUP_DB_SET_NAME_WITH_SUSER_TEXT'                 => "Choisissez un nom d'utilisateur et un mot de passe pour la base de données.",
    'SETUP_SET_ADMIN_ACCOUNT_TITLE'                     => "Ajouter un utilisateur admin",
    'SETUP_SET_ADMIN_ACCOUNT_TEXT'                      => "Veuillez définir les identifiants de l'utilisateur admin de cette application.", 
    'SETUP_WIZARD_BUTTON_CLOSE'                         => "Quitter",
    'SETUP_WIZARD_BUTTON_INSTALL'                       => "Installer",
    'SETUP_INSTALL_SUCCESSFULL'                         => "Félicitations ! <br>L'installation a réussi. Vous pouvez vous connecter dès maintenant.",
    'SETUP_TERMINATE_TITLE'                             => "Terminer l'installation",
    'SETUP_TERMINATE_MESSAGE'                           => "Appuyez sur 'Installer' pour démarrer l'installation.",
    'SETUP_TERMINATE_WARNING'                           => "La configuration va prendre quelques instants. <br>Veillez à maintenir la connexion pendant l'installation.",
    'SQL_HOST_FIELD'                                    => "Hôte de la base de données :",
    'SQL_HOST_PLACEHOLDER'                              => "Hôte de la base de données (ex. localhost)",
    'SQL_ADMIN_NAME_FIELD'                              => "Nom du super-utilisateur :",
    'SQL_ADMIN_NAME_PLACEHOLDER'                        => "Nom du super-utilisateur (par ex. root)",
    'SQL_ADMIN_PASSWORD_FIELD'                          => "Mot de passe super-utilisateur :",
    'SQL_ADMIN_PASSWORD_PLACEHOLDER'                    => "Mot de passe super-utilisateur",
    'DB_NAME_FIELD'                                     => "Nom de la base de données :",
    'DB_NAME_PLACEHOLDER'                               => "Nom de la base de données",
    'DB_USER_NAME_FIELD'                                => "Nom d'utilisateur :",
    'DB_USER_NAME_PLACEHOLDER'                          => "Nom d'utilisateur",
    'DB_USER_PASSWORD_FIELD'                            => "Mot de passe :",
    'DB_USER_PASSWORD_PLACEHOLDER'                      => "Mot de passe",
    'DB_ADMIN_NAME_FIELD'                               => "Nom d'utilisateur :",
    'DB_ADMIN_NAME_PLACEHOLDER'                         => "Nom d'utilisateur",
    'DB_ADMIN_PASSWORD_FIELD'                           => "Mot de passe :",
    'DB_ADMIN_PASSWORD_PLACEHOLDER'                     => "Mot de passe",
    'DB_ADMIN_EMAIL_FIELD'                              => "Adresse email :",
    'DB_ADMIN_EMAIL_PLACEHOLDER'                        => "Adresse email",
       
);