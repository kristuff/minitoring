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

namespace Kristuff\Minitoring\Model\System;

use Kristuff\Miniweb\Data\Model\DatabaseModel;

/** 
 * SystemModel
 */
class SystemBaseModel extends DatabaseModel
{
    /**
     * Get alert code
     *
     * Get/returns the alert code (ie: 0, 1 or 2) for the given percent error.
     * Currents rules are followings:
     *   0:    %error < 50   (state ok)
     *   1:    %error < 75   (state warning)
     *   2:    %error >= 75  (state error)
     * 
     * TODO: custome threshold
     * 
     * @access public
     * @static method
     * @param  int    $percentError     The error state in percent
     *
     * @return int
     */
    public static function getAlertCode($percentError)
    {
        $val = (int)$percentError;
        if ($val < 50){
            return 0;
        } elseif ($val < 75 ){
            return 1;
        }
        return 2;
    }

    /**
     * Returns human size
     *
     * @access public
     * @static
     * @param float     $filesize       File size in bytes.
     * @param int       $decimals       (optional) Number of decimals. Default is 2.
     *
     * @return string            
     */
    public static function getSize($filesize, $decimals = 2)
    {
        $units = array('', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y');

        foreach ($units as $idUnit => $unit){
            if ($filesize < 1024){
                break;
            }
            $filesize /= 1024;
        }
        
        return round($filesize, $decimals).' '.$units[$idUnit].'B';
    }

    /**
     * Seconds to human readable text
     * Eg: for 36545627 seconds => 1 year, 57 days, 23 hours and 33 minutes
     * 
     * @return string Text
     */
    public static function getHumanTime($seconds)
    {
        $seconds = self::getNumeric($seconds);
        $units = array(
            'year'   => 365*86400,
            'day'    => 86400,
            'hour'   => 3600,
            'minute' => 60,
            // 'second' => 1,
        );
        

         $parts = array();
     
        foreach ($units as $name => $divisor)
        {
            $div = floor($seconds / (int)$divisor);
     
            if ($div == 0)
                continue;
            else
                if ($div == 1)
                    $parts[] = $div.' '.$name;
                else
                    $parts[] = $div.' '.$name.'s';
            $seconds %= (int)$divisor;
        }
     
        $last = array_pop($parts);
     
        if (empty($parts))
            return $last;
        else
            return join(', ', $parts).' and '.$last;
    }

    /**
     * TODO
     * Seconds to human readable text
     * Eg: for 36545627 seconds => 1 year, 57 days, 23 hours and 33 minutes
     * 
     * @return string Text
     */
    public static function splitTime($seconds)
    {
        $seconds = self::getNumeric($seconds);
        $time = [];
        $units = array(
            'year'   => 365*86400,
            'day'    => 86400,
            'hour'   => 3600,
            'minute' => 60,
        );
        
        foreach ($units as $name => $divisor){
           $time[$name] = floor($seconds / (int)$divisor);
           $seconds %= (int)$divisor;
        }
        
        return $time;
    }

    /**
     * Returns a command that exists in the system among $cmds
     *
     * @access public
     * @static
     * @param array  $cmds             List of commands
     * @param string $args             List of arguments (optional)
     * @param bool   $returnWithArgs   If true, returns command with the arguments
     *
     * @return string                   Command
     */
    public static function whichCommand(array $cmds, string $args = '', bool $returnWithArgs = true)
    {
        $return = '';

        foreach ($cmds as $cmd){
            if (trim(shell_exec($cmd.' 2>/dev/null '.$args)) != ''){
                $return = $cmd;
                
                if ($returnWithArgs){
                    $return .= $args;
                }
                break;
            }
        }

        return $return;
    }

    /**
     * Remove all non numeric chars from a string
     * 
     * @access public
     * @static
     * @param  string   $value
     * 
     * @return string                   
     */
    public static function getNumeric($value)
    {
        return preg_replace("/[^0-9,.]/", "", $value);
    }

}