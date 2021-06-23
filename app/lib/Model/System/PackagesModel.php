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

use Kristuff\Minitoring\Model\System\SystemModel;

/** 
 * PackagesModel
 */
class PackagesModel extends SystemModel
{

    /**
     * Force EN language to standardize output on ant machine
     * 
     * @access protected
     * @static
     * 
     * @return void
     */
    protected static function setLanguage(): void
    {
        $locale = 'en_US.UTF-8'; //'fr_FR.UTF-8'
        setlocale(LC_ALL, $locale);
        putenv('LC_ALL='.$locale);
    }

    /**
     * Get installed packages (include removed packages with conf files still present)
     * 
     * @access public
     * @static
     * 
     * @return array
     */
    public static function getPackages(): array
    {
        self::setLanguage();

        $packages = [];
        $errors = 0;
        $installed = 0;

        if (exec("dpkg-query --list --no-pager", $list)){

            // remove header lines
            unset($list[0]);
            unset($list[0]);
            unset($list[0]);
            unset($list[0]);
            unset($list[0]);

            foreach($list as $line){
                $expr = '#^(?P<_action>[a-zA-Z])(?P<_status>[a-zA-Z])(?P<_error>[A-Z]|)\s+(?P<name>[^ ]+)\s+(?P<version>[^ ]+)\s+(?P<arch>[^ ]+)\s+(?P<description>.+)#';
                if (preg_match($expr, $line, $matches)) {
                    $parsed = [];
                    foreach (array_filter(array_keys($matches), 'is_string') as $key) {
                        $parsed[$key] = trim($matches[$key]);
                    }

                    /* parse state..

                        Desired action:
                        u = Unknown
                        i = Install
                        h = Hold
                        r = Remove
                        p = Purge
        
                        Package status:
                        n = Not-installed
                        c = Config-files
                        H = Half-installed
                        U = Unpacked
                        F = Half-configured
                        W = Triggers-awaiting
                        t = Triggers-pending
                        i = Installed

                        Error flags:
                        <empty> = (none)
                        R = Reinst-required
                     */
                    
                    switch ($parsed['_error']){
                        case '':   $parsed['error'] = ''; break;
                        case 'R':  $parsed['error'] = 'Reinstall required'; $errors++;  break;
                        default:   $parsed['error'] = 'Unknown error';      $errors++;  break;     
                    }

                    switch ($parsed['_action']){
                        case 'u':  $parsed['action'] = 'Unknown'; break;
                        case 'i':  $parsed['action'] = 'Install'; break;
                        case 'h':  $parsed['action'] = 'Hold';    break;
                        case 'r':  $parsed['action'] = 'Remove';  break;
                        case 'p':  $parsed['action'] = 'Purge';   break;
                    }

                    switch ($parsed['_status']){
                        case 'n':  $parsed['status'] = 'Not-installed';     $parsed['status_code'] = 'info';    break;
                        // warning when only config files are present
                        case 'c':  $parsed['status'] = 'Config-files';      $parsed['status_code'] = 'warning'; break;
                        case 'H':  $parsed['status'] = 'Half-installed';    $parsed['status_code'] = 'warning'; break;
                        case 'U':  $parsed['status'] = 'Unpacked';          $parsed['status_code'] = 'warning'; break;
                        case 'F':  $parsed['status'] = 'Half-configured';   $parsed['status_code'] = 'warning'; break;
                        case 'W':  $parsed['status'] = 'Triggers-awaiting'; $parsed['status_code'] = 'warning'; break;
                        case 't':  $parsed['status'] = 'Triggers-pending';  $parsed['status_code'] = 'info';    break;
                        case 'i':  $parsed['status'] = 'Installed';         $parsed['status_code'] = 'success'; $installed++; break;
                    }
                    $packages[] = $parsed;
                }
            }
        }

        return [
            'packages'  => $packages,
            'number'    => count($packages),
            'errors'    => $errors,
            'number_total'      => count($packages),
            'number_installed'  => $installed,
            'number_error'      => $errors,
        ];
    }

    /**
     * Get upgradable packages 
     * 
     * @access public
     * @static
     * 
     * @return array
     */
    public static function getUpgradablePackages(): array
    {
        self::setLanguage();
        
        $packages = [];
        if (exec("apt list --upgradable 2>/dev/null", $list)){

            foreach($list as $line){
                if ($line != 'Listing...'){

                    $expr = '#^(?P<name>[a-z0-9\-\+\.]+)/(?P<suite>.+) (?<version>.+) (?<arch>.+) \[upgradable from: (?<current_version>.+)\]#';
                    if (preg_match($expr, $line, $matches)) {
                        $parsed = [];
                        foreach (array_filter(array_keys($matches), 'is_string') as $key) {
                            $parsed[$key] = trim($matches[$key]);
                        }
                        $packages[] = $parsed;
                    }
                }
            }
        }

        return [
            'packages' => $packages,
            'number'   => count($packages),
            'message'  => count($packages) === 0 ? self::text('PACKAGES_UPGRADE_NONE') : '',
        ];
   }


}