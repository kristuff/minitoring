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
 * Texts used in the application.
 */
return array(

    /* app errors */
    'ERROR_UNEXPECTED'                                  => 'Une erreur inconnue est survenue.',
    'ERROR_PATH_MISSING'                                => "Le répertoire '%s' est introuvable",
    'ERROR_PATH_PERMISSIONS'                            => "Le répertoire '%s' n'est pas accessible en écriture (mauvaises permissions).",
    'ERROR_LOGFILE_NOT_FOUND'                           => "Le fichier '%s' est introuvable.",
    'ERROR_LOGFILE_NOT_READABLE'                        => "Le fichier '%s' n'est pas accessible en lecture (mauvaises permissions).",
    'ERROR_LOGFILE_WRONG_TYPE'                          => "Le type spécifié '%s' n'est pas un type de log valide.",
    'ERROR_LOGNAME_ALREADY_EXISTS'                      => "Un journal avec le même nom existe déja. Choisissez un autre nom.",
    'ERROR_LOGNAME_EMPTY'                               => "Vous devez définir un nom de journal.",

    /* UI */
    'BUTTON_OK'                                         => "OK",
    'BUTTON_CANCEL'                                     => "Annuler",
    'THEME_DARK'                                        => 'Foncé',
    'THEME_LIGHT'                                       => 'Clair',
    'COLOR_YELLOW'                                      => 'Jaune',
    'COLOR_RED'                                         => 'Rouge',
    'COLOR_GREEN'                                       => 'Vert',
    'COLOR_BLUE'                                        => 'Bleu',
    'COLOR_MAGENTA'                                     => 'Violet',
    'COLOR_ORANGE'                                      => 'Orange',

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

    /* Packages */
    'PACKAGES'                                          => 'Packages',
    'PACKAGES_UPGRADE_NONE'                             => 'Tous les paquets sont à jour',

    /* Logs */
    'LOGS'                                              => 'Journaux',
    'LOGS_REFRESH_NONE'                                 => 'Ne pas rafraîchir',
    'LOGS_REFRESH_XSECONDS'                             => 'Rafraîchir toutes les %ss',
    'LOGS_DISPLAY_XLINES'                               => 'Afficher %s lignes',

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




    'SETTINGS_INFOS'                                    => 'A propos',
    'SETTINGS_INFOS_TITLE'                              => 'A propos',
    'SETTINGS_INFOS_SUMMARY'                            => "Informations sur cette application",
    'SETTINGS_INFOS_DEPENDENCIES'                       => 'Dépendences installées',
    'DEPENDENCY_LIBRARY'                                => 'Bibliothèque',
    'DEPENDENCY_VERSION'                                => 'Version',


    'SETTINGS_DATA'                                     => 'Données',
    'SETTINGS_DATA_SUMMARY'                             => "Données de l'application",
    
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



    'SETTINGS_LOGREADER'                                => 'Journaux',
    'SETTINGS_LOGREADER_SUMMARY'                        => "Paramètres du lecteur de journaux",
    'SETTINGS_LOGREADER_LIST_TITLE'                     => "Fichiers journaux enregistrés",
    'SETTINGS_LOGREADER_DIALOG_CREATE_TITLE'            => "Ajouter un nouveau fichier journal",
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
    'SETTINGS_LOGREADER_FORMAT_PLACEHOLDER'             => "Format (laissez vide pour utiliser le format par défaut)",
    'SETTINGS_LOGREADER_BUTTON_ADD'                     => "Ajouter",
    'SETTINGS_LOGREADER_ADVANCED'                       => "Avancé",
    'SETTINGS_LOGREADER_IP_ACTION_FIELD'                => "Sélectionnez une action pour les adresses IP (fonctionne principalement dans les journaux web) :",
    'SETTINGS_LOGREADER_IP_ACTION_NONE'                 => "Aucune",
    'SETTINGS_LOGREADER_IP_ACTION_ABUSEIPDB'            => "Vérification sur AbuseIPDB (lien externe)",
    'SETTINGS_LOGREADER_IP_ACTION_GEOIP'                => "Geodatatool (lien externe)",

    'SETTINGS_SERVICES'                                 => 'Services',
    'SETTINGS_SERVICES_SUMMARY'                         => "Créer ou modifier les services à surveiller",

    'SETTINGS_BANS'                                     => 'Parefeu',
    'SETTINGS_BANS_SUMMARY'                             => "Fail2Ban and abuseIPDB API settings",



);