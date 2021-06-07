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

namespace Kristuff\Minitoring\Model\Services;

use Kristuff\Miniweb\Data\Model\DatabaseModel;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Patabase\Driver\Sqlite\SqliteDatabase;

/** 
 * 
 */
class Fail2banModel extends DatabaseModel
{
    /**
     * var SqliteDatabase $database
     */
    private static $fail2banDb = null;

    /** 
     * Util function that executs shell command and get first line from output
     * 
     * @access public
     * @static
     * @param string    $cmd
     *
     * @return string|false
     */
    private static function getExecSingleValue(string $cmd)
    {
        if (@exec($cmd, $output)){
            if (isset($output[0])){
                return $output[0];
            }
        }
        return false;
    }

    /* -------------- */
    /* --- COMMON --- */
    /* -------------- */


    /** 
     * Get the server version 
     * Example: 0.10.2
     *
     * @access public
     * @static
     *
     * @return string|false
     */
    public static function getVersion()
    {
        return self::getExecSingleValue('fail2ban-client version');
    }

    /** 
     * Get the database file path
     * 
     * Command fail2ban-client get dbfile returns something like this:
     * Current database file is:
     * `- /var/lib/fail2ban/fail2ban.sqlite3
     * 
     * @access protected
     * @static
     * 
     * @return string
     */
    protected static function getDatabaseName()
    {
        return exec('fail2ban-client get dbfile | awk \'{print $2}\'');
    }
    
    /** 
     * Get a SqliteDatabase instance for fail2ban database
     * 
     * @access protected
     * @static
     * 
     * @return SqliteDatabase
     */
    protected static function f2bDatabase()
    {
        if (empty(self::$fail2banDb)) {
            self::$fail2banDb = SqliteDatabase::createInstance(self::getDatabaseName());
        }
        return self::$fail2banDb;
    }

    /**
     * Get active jails
     *
     * @access public
     * @static
     *
     * @return array    
     */
    public static function getActiveJails()
    {
        $out = array();
        exec("fail2ban-client status | grep \"Jail list\" | sed -E 's/^[^:]+:[ \t]+//' | sed 's/,//g'", $out);
        if (!empty($out)){
            return explode(" ", $out[0]);
        }
        return $out;
    }
   
    /**
     * Get jails from database. Include enabled and disabled jails
     *
     *
     * @access public
     * @static
     *
     * @return array    
     */
    public static function getJails()
    {
        $query = self::f2bDatabase()->select('name', 'enabled')
                                  ->from('jails');

        // sub query To get bans number for given jail
        // note the prefix Patabase\Constants::COLUMN_LITERALL required
        $query->select('bans')
              ->count('bans')
              ->from('bans')
              ->whereEqual('bans.jail', \Kristuff\Patabase\Constants::COLUMN_LITERALL.'jails.name');

        // sub query To get log files number for given jail
        // note the prefix Patabase\Constants::COLUMN_LITERALL required
        $query->select('logs')
              ->count('logs')
              ->from('logs')
              ->whereEqual('logs.jail', \Kristuff\Patabase\Constants::COLUMN_LITERALL.'jails.name');

        return $query->getAll('ASSOC');

    }

    /** 
     * Get log level  
     * 
     * Command fail2ban-client get loglevel returns something like this:
     * Current logging level is 'INFO'
     * 
     * @access public
     * @static
     *
     * @return string|false
     */
    public static function getLogLevel()
    {
        $result = self::getExecSingleValue('fail2ban-client get loglevel');
        if (preg_match("#Current logging level is '(?P<level>[\w]+)'#", $result, $out)){
            return $out['level'];
        }
     
        return false;
    }

    /** 
     * Get Informations about server. Include jails list
     * 
     * @access protected
     * @static
     * 
     * @return array
     */
    public static function getServerInfos()
    {
        $dbPath = self::getDatabaseName();
        $dbSize = filesize($dbPath);
        $data   = array();

        // get older ban time
        $minDate = self::f2bDatabase()->select()->min('timeofban', 'time')->from('bans')->getColumn();

        $data['version']            = self::getVersion();
        $data['status']             = 'TODO';
        $data['jails']              = self::getJails();
        $data['databasePath']       = self::getDatabaseName();
        $data['databaseSize']       = \Kristuff\Miniweb\Core\Format::getSize($dbSize);
        $data['databaseSizeBytes']  = $dbSize;
        $data['logLevel']           = self::getLogLevel(); 
        $data['olderBanTime']       = $minDate;
        $data['olderBanAge']        = \Kristuff\Miniweb\Core\Format::getHumanTime(time() - $minDate, 'day') .' ago'; 

        return $data;
    }
    
    /* ------------ */
    /* --- JAIL --- */
    /* ------------ */

    /** 
     * Get a single jaim config parameter
     * 
     * @access protected
     * @static
     * @param string    $jail           The jail name
     * @param string    $parameter      The jail parameter
     * 
     * @return string
     */
    protected static function getJailParameter(string $jail, string $parameter)
    {
        return exec('fail2ban-client get ' . $jail . ' ' . $parameter);
    }

    /** 
     * Get the bantime value for give jail
     * 
     * @access protected
     * @static
     * @param string    $jail           The jail name
     * 
     * @return string
     */
    protected static function getJailBantime(string $jail)
    {
        return self::getJailParameter($jail, 'bantime');
    }

    /** 
     * Get the maxretry value for give jail
     * 
     * @access protected
     * @static
     * @param string    $jail           The jail name
     * 
     * @return string
     */
    protected static function getJailMaxRetry(string $jail)
    {
        return self::getJailParameter($jail, 'maxretry');
    }
    
    /** 
     * Get the findtime valie for give jail
     * 
     * @access protected
     * @static
     * @param string    $jail           The jail name
     * 
     * @return string
     */
    protected static function getJailFindTime(string $jail)
    {
        return self::getJailParameter($jail, 'findtime');
    }

    /**
     * Get jail status
     *
     * Calling fail2ban-client status <JAIL> will return something like this:
     * Status for the jail: <JAIL>
     * |- Filter
     * |  |- Currently failed: 0
     * |  |- Total failed:     0
     * |  `- File list:        /var/log/1.log /var/log/2.log /var/log/3.log
     * `- Actions
     * |- Currently banned: 0
     * |- Total banned:     0
     * `- Banned IP list:   IP1 IP2 IP3
     * 
     * @access public
     * @static
     * @param string    $jail       The jail name
     *
     * @return array    
     */
    public static function getJailStatus(string $jail, bool $includeIpList = true): array
    {
        $status = [];
        $searchIndex = 0;
        $patterns = [
            'currentlyFailed'   => "#.*Currently failed:\s+(?P<currentlyFailed>[\d]+)#",
            'totalFailed'       => "#.*Total failed:\s+(?P<totalFailed>[\d]+)#",
            'fileList'          => "#.*File list:\s+(?P<fileList>.*)#",
            'currentlyBanned'   => "#.*Currently banned:\s+(?P<currentlyBanned>[\d]+)#",
            'totalBanned'       => "#.*Total banned:\s+(?P<totalBanned>[\d]+)#",
            'bannedIpList'      => "#.*Banned IP list:\s+(?P<bannedIpList>[\d\s\.:]+)#",
        ];

        if (in_array($jail, self::getActiveJails())){

            exec("fail2ban-client status " . $jail, $out);

            foreach ($out as $row) {

                for ($i=$searchIndex; $i<count($patterns); $i++) {

                    $key = array_keys($patterns)[$i];
                    if (preg_match($patterns[$key], $row, $output)) {
                        switch($key){
                            case 'fileList':
                            case 'bannedIpList':
                                $status[$key] = explode(' ', trim($output[$key]));
                                break;
                            default:
                                // integer
                                $status[$key] = intval(trim($output[$key]));
                        }
                        $searchIndex++;

                        // check for exit
                        if (!$includeIpList && $searchIndex === 5){
                            break;
                        }
                    }
                }
            }
                    
        } 
        return $status;
    }










  

    /**
     * Get active jails
     *
     * Calling fail2ban-client status will return something like this:
     * Status
     * |- Number of jail:      10
     * `- Jail list:   apache-404, apache-auth, apache-noscript, apache-w00tw00t, postfix, postfix-auth, postfix-relay, sshd, wordpress-wlwmanifest, wordpress-xmlrpc
     *
     * @access public
     * @static
     *
     * @return array    
     */
    public static function getJailsInfos()
    {
        $jails = self::f2bDatabase()->select('name', 'enabled')
                                    ->from('jails')
                                    ->getAll('ASSOC');

        //$_jails = new \ArrayObject($jails);
        //$copy = $_jails->getArrayCopy();
        foreach($jails as $key=>$value) {
            
            $jail = $value['name'];
        //    $enabled = ($value['enabled'] == 1); 

            $jails[$key]['logs'] = self::f2bDatabase()->select('path', 'firstlinemd5', 'lastfilepos')
                                    ->from('logs')
                                    ->whereEqual('jail', $jail)
                                    ->getAll('ASSOC');

            $jails[$key]['bans'] = self::f2bDatabase()->select('ip', 'timeofban', 'data')
                                    ->from('bans')
                                    ->whereEqual('jail', $jail)
                                    ->getAll('ASSOC');

           // $jails[$key]['bantime'] = $enabled ? self::getJailBantime($jail) : '-';
           // $jails[$key]['maxretry'] = $enabled ? self::getJailMaxRetry($jail) : '-';
           // $jails[$key]['findtime'] = $enabled ? self::getJailFindTime($jail) : '-';

            //$bans = self::f2bDatabase()->   
        }

        return $jails;

    }


  

   
    
   
     
    /** 
     * Set log level  
     *
     * @access public
     * @static
     *
     * @return string|false
     */
    public static function setLogLevel(string $level)
    {
        //todo     CRITICAL,ERROR,WARNING,NOTICE,INFO,DEBUG,TRACEDEBUG,HEAVYDEBUG 
        //return self::getExecSingleValue('fail2ban-client get loglevel');
    }



}