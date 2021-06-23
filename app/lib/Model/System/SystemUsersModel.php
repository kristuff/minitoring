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
 * @version    0.1.5
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\System;

use Kristuff\Miniweb\Mvc\Data\DatabaseModel;
use Kristuff\Minitoring\Model\System\SystemModel;

/** 
 * SystemUsersModel
 */
class SystemUsersModel extends SystemModel
{
    /**
     * @access protected
     * @static
     * @var array $systemUsers
     */
    protected static $systemUsers = [
        'root' => '',
        
    ];

    /** 
     * Get all groups from getent
     *
     * @access public
     * @static
     * @param  int      $limit      (optional) The limit for result. Default is 20
     * @param  int      $offset     (optional) The offset. Default is 0.
     *
     * @return array
     */
    public static function getGroups($limit = 20, $offset = 0)
    {
        // data to return
        $datas = [
            'total'  =>  0,
            'offset' => $offset,
            'limit'  => $limit,
            'groups'  => [],
        ];
        
        if (exec('getent group', $groups)){
            // set total
            $datas['total'] = count($groups) ; 
             
             // populate users datas
             for ($i = (0 + $offset); $i < count($groups) && $i < ($limit + $offset); $i++){
                 list($name, $password, $gid, $users) = explode(':', $groups[$i]);
 
                 $datas['groups'][] = array(
                         'name'           => $name,
                     //  'password'       => $password,
                         'gid'            => $gid,
                         'users'          => explode(',', $users),
                 );
             }
        }
        return $datas;

    }

    /** 
     * Get all users from getent
     *
     * @access public
     * @static
     * @param  int      $limit      (optional) The limit for result. Default is 20
     * @param  int      $offset     (optional) The offset. Default is 0.
     *
     * @return array
     */
    public static function getAllUsers($limit = 20, $offset = 0)
    {
        // data to return
        $datas = [
            'total'  =>  0,
            'offset' => $offset,
            'limit'  => $limit,
            'users'  => [],
        ];
        
        if (exec('getent passwd', $users)){

            // sort by name
            //sort($users);
            
            // set total
            $datas['total'] = count($users) ; 
             
             // populate users datas
             for ($i = (0 + $offset); $i < count($users) && $i < ($limit + $offset); $i++){
                 list($name, $password, $uid, $gid, $gecos, $directory, $shell ) = explode(':', $users[$i]);
 
                 $datas['users'][] = array(
                         'name'           => $name,
                     //  'password'       => $password,
                         'uid'            => $uid,
                         'gid'            => $gid,
                         'gecos'          => explode(',', $gecos),
                         'homeDirectory'  => $directory,
                         'loginShell'     => $shell,
                         'hasLoginShell'  => ($shell === '/bin/sync'  ||
                                              $shell === '/usr/sbin/nologin'  || 
                                              $shell === '/sbin/nologin' || 
                                              $shell === '/bin/false') ? false : true,      
                );
            }
        }

        return $datas;
   }

    /** 
     * Get all users from lastlog
     *
     * @access public
     * @static
     * @param  int      $limit      (optional) The limit for result. Default is 20
     * @param  int      $offset     (optional) The offset. Default is 0.
     *
     * @return array
     */
    public static function getUsers($lastLogins = false, $limit = 20, $offset = 0)
    {
        // data to return
        $datas = [
            'total' =>  0,
            'offset' => $offset,
            'limit' => $limit,
            'users' => []
        ];
        
        // gets users
        $cmd = sprintf('%s | /usr/bin/awk  -F\' \' \'{ print $1";" $2";" $3";"$4", "$5" "$6", "$9" "$7}\'', 
                $lastLogins ? '/usr/bin/lastlog --time 365' : '/usr/bin/lastlog'); 

        if (exec($cmd, $users)){

            // remove header and sort by name
            array_splice($users, 0, 1);
            sort($users);
            
            // set total
            $datas['total'] = count($users) ; 
             
            // populate users datas
            for ($i = (0 + $offset); $i < count($users) && $i < ($limit + $offset); $i++){

                $neverLogeedIn = strpos($users[$i], '**Never;logged;in**') !== false;
                list($user, $port, $from, $date) = explode(';', $users[$i]);

                $datas['users'][] = [
                    'user' => $user,
                    'port' => !$neverLogeedIn ? $port : '',
                    'from' => !$neverLogeedIn ? $from : '',
                    'date' => !$neverLogeedIn ? $date : ''
                ];
            }
        }

        return $datas;
    }

    /** 
     * 
     *
     * @access public
     * @static
     *
     * @return array
     */
    public static function getCurrentsUsers($limit = 20, $offset = 0)
    {
        // data to return
        $datas = [
            'total' =>  0,
            'offset' => $offset,
            'limit' => $limit,
            'users' => []
        ];

        // get users
        if (exec('who -u | /usr/bin/awk \'{print $1";" $2";" $7";" $3" "$4" "$5";" $8}\'', $users)){

            // sort by name
            sort($users);
            
            // set total
            $datas['total'] = count($users) ; 
            
            // populate users datas
            for ($i = (0 + $offset); $i < count($users) && $i < ($limit + $offset); $i++){
                list($user, $port, $pid, $date, $comment) = explode(';', $users[$i]);

                $datas['users'][] = array(
                        'user'      => $user,
                        'port'      => $port,
                        'pid'       => $pid,
                        'date'      => $date,
                        'comment'   => trim($comment, '()'),
                );
            }
        }
        return $datas;
    }

    /** 
     * 
     *
     * @access public
     * @static 
     *
     * @return array|string
     */
    public static function getCurrentUsersNumber(string $replacement = 'N.A')
    {
        if (!($nbCurrentUsers = shell_exec('who -u | awk \'{ print $1 }\' | wc -l'))){
            return $replacement;
        }
        return str_replace("\n", '', $nbCurrentUsers);
    }
}
