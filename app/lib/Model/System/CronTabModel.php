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
 * @version    0.1.17
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\System;

/** 
 * CronTabModel
 */
class CronTabModel extends SystemModel
{

    
    protected static function isComment(string $value) : bool
    {
        return strpos($value, '#') === 0;
    }

    protected static function isEmptyLine(string $value) : bool
    {
        return empty(trim($value)); 
    }

    protected static function isEnvVariable(string $value) : bool
    {
        return preg_match('/.*=.*/', $value) === 1 ;
    }

    protected static function parseCron(string $line, bool $withUserField = false) : array
    {
        // replace tabs with single space
        $line = trim(preg_replace('/\t/', ' ', $line));

        //$namedPattern = '';
        //$pattern1 = '(\*|([0-9]|0[1-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])|\*\/([0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]))';
        // \\s
        //$pattern2 ='(\*|([0-9]|1[0-9]|2[0-3])|\*\/([0-9]|1[0-9]|2[0-3]))\\s(\*|([1-9]|1[0-9]|2[0-9]|3[0-1])|\*\/([1-9]|1[0-9]|2[0-9]|3[0-1]))\\s(\*|([1-9]|1[0-2])|\*\/([1-9]|1[0-2]))\\s(\*|([0-7])|\*\/([0-7]))'; 

        // This should allow the * or */num and also limit the number values
        // to their logical range (1-12 for months, 0-24 for hours, and so on)
        //$expr =  '#^(?P<time>(\*|([0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])|\*\/([0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]))\\s(\*|([0-9]|1[0-9]|2[0-3])|\*\/([0-9]|1[0-9]|2[0-3]))\\s(\*|([1-9]|1[0-9]|2[0-9]|3[0-1])|\*\/([1-9]|1[0-9]|2[0-9]|3[0-1]))\\s(\*|([1-9]|1[0-2])|\*\/([1-9]|1[0-2]))\\s(\*|([0-7])|\*\/([0-7]))) (?P<command>.+)#';
        //$expr =  '#^(?P<time>(\*|([0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])|\*\/([0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]))\\s(\*|([0-9]|1[0-9]|2[0-3])|\*\/([0-9]|1[0-9]|2[0-3]))\\s(\*|([1-9]|1[0-9]|2[0-9]|3[0-1])|\*\/([1-9]|1[0-9]|2[0-9]|3[0-1]))\\s(\*|([1-9]|1[0-2])|\*\/([1-9]|1[0-2]))\\s(\*|([0-7])|\*\/([0-7]))) (?P<command>.+)#';
        
        $expr = '#^(?P<time>(\*|\/|[0-9]|L|W|\#|,|\-|\\s|@annually|@yearly|@monthly|@weekly|@daily|@hourly)+) (?P<command>.+)#';

        if ($withUserField) {
            $exprCron    = '(?P<time>(\*|\/|[0-9]|L|W|\#|,|\-|\\s|@annually|@yearly|@monthly|@weekly|@daily|@hourly)+)';
            $exprUser    = '(?P<user>.+)';
            $exprCommand = '(?P<command>.+)';
            $expr = '#^'.$exprCron.' '.$exprUser.' '.$exprCommand.'#';  
        }

        if (preg_match($expr, $line, $matches)) {

            foreach (array_filter(array_keys($matches), 'is_string') as $key) {
                $result[$key] = trim($matches[$key]);
            }
            return $result;
        }

        return [
            'time' => '', 
            'command' => ''
        ];
    }

    /** 
     * Get cron tab list
     *
     * @access public
     * @static
     * 
     * @return array
     */
    public static function getAll()
    {  
        return array(
            'users'   => self::getUserCrons(),
            'system'  => self::getSystemCron(),
            'crond'   => self::getCronD(),
            'timers'  => self::getSystemTimers(),
        ); 
    }

    /** 
     * Get system crontab list under /etc/cron.d 
     *
     * @access public
     * @static
     * 
     * @return array
     */
    public static function getCronD() : array
    {   
        $list = [];
        $directory = new \DirectoryIterator('/etc/cron.d');
        $dateTimeFormat = self::text('DATE_TIME_FORMAT') ?? 'Y-m-d H:i:s';

        foreach ($directory as $fileinfo) {
            if (!$fileinfo->isDot() && !$fileinfo->isDir() && $fileinfo->getFilename() !== '.placeholder') {

                $dir = $fileinfo->getPathname();
                $crons = []; // need to reset crons list 

                if (exec("/usr/bin/cat $dir", $crons)){

                    // loop into filtered array
                    foreach (array_filter($crons) as $cron){

                        // remove comments and env variables
                        if (!self::isComment($cron) && !self::isEnvVariable($cron)){

                            $parsedCron = self::parseCron($cron);
                     
                            if (!empty($parsedCron['time'])){
                                $parser = new \Cron\CronExpression($parsedCron['time']);
                             }

                            $list[] = [
                                'file'              => $fileinfo->getFilename(),
                                'path'              => $fileinfo->getPathname(),
                                'cron'              => $cron,
                                'timeExpression'    => $parsedCron['time'],
                                'command'           => $parsedCron['command'],
                                'nextRun'           => !empty($parser) ? $parser->getNextRunDate() : '',
                                'nextRunDate'       => !empty($parser) ? $parser->getNextRunDate()->format($dateTimeFormat) : '',
                           ]; 
                        }
                    }
                }
            }
        }

        return $list;
    }

    /** 
     * Get system cron tab list
     *
     * @access public
     * @static
     * 
     * @return array
     */
    public static function getSystemCron(): array
    {   
        $list = [];
        $dateTimeFormat = self::text('DATE_TIME_FORMAT') ?? 'Y-m-d H:i:s';
        $systemPaths = [
            '/etc/cron.hourly',
            '/etc/cron.daily',
            '/etc/cron.weekly',
            '/etc/cron.monthly',
        ];

        if (exec('cat /etc/crontab', $crons)){

            // loop into filtered array
            foreach (array_filter($crons) as $cron){

                // remove comments and env variables
                if (!self::isComment($cron) && !self::isEnvVariable($cron) && !self::isEmptyLine($cron)){

                    $scripts = [];

                    // get sub commands defines in system paths (ie: etc/cron.daily, cron.weekly, ...)
                    foreach($systemPaths as $path){
                        if (strpos($cron, $path) !== false){

                            $dir = new \DirectoryIterator($path);
                            foreach ($dir as $fileinfo) {

                                if (!$fileinfo->isDot() && !$fileinfo->isDir() && $fileinfo->getFilename() !== '.placeholder') {
                                    $scripts[] = [
                                        'name'      => $fileinfo->getFilename(),
                                        'path'      => $fileinfo->getPathname(),
                                        'type'      => $fileinfo->getType(),
                                        'isLink'    => $fileinfo->isLink(),
                                        'owner'     => $fileinfo->getOwner(),
                                        'group'     => $fileinfo->getGroup(),
                                        'mTime'     => $fileinfo->getMTime(),
                                        'aTime'     => $fileinfo->getMTime(),
                                        'cTime'     => $fileinfo->getCTime(),
                                    ];
                                }
                            }
                        }
                    }
                    $parsedCron = self::parseCron($cron);

                    if (!empty($parsedCron['time'])){
                        $parser = new \Cron\CronExpression($parsedCron['time']);
                    }

                    $list[] = [
                        'cron'              => $cron,  // the full line
                        'timeExpression'    => $parsedCron['time'],
                        'command'           => $parsedCron['command'],
                        'nextRun'           => !empty($parser) ? $parser->getNextRunDate() : '',
                        'nextRunDate'       => !empty($parser) ? $parser->getNextRunDate()->format($dateTimeFormat) : '',
                        'scripts'           => $scripts,
                    ]; 
                }
            }
        }
        return $list;
    }

    /** 
     * Get users cron tab list
     *
     * @access public
     * @static
     * 
     * @return array
     */
    public static function getUserCrons(): array
    {
        // for user in $(cut -f1 -d: /etc/passwd); do crontab -u $user -l 2>/dev/null | grep -v '^#'; done
        //if (!(exec('for user in $(cut -f1 -d: /etc/passwd); do echo $user; crontab -u $user -l; done', $data))){

        $list=[];
        $dateTimeFormat = self::text('DATE_TIME_FORMAT') ?? 'Y-m-d H:i:s';

        //todo
        if (exec('cut -f1 -d: /etc/passwd', $users)){

            foreach ($users as $user){
                // this command works as expected in terminal but returns nothing with PHP ?
                // $cmd = 'crontab -u ' . $user . ' -l 2>/dev/null | grep -v "^#"';
                // so remove grep part and filter array with PHP
                $cmd = 'crontab -u ' . $user . ' -l 2>/dev/null';
                $crons = []; // required for clearing list between users  

                if (exec($cmd, $crons)){

                    // loop into filtered array
                    foreach (array_filter($crons) as $cron){

                        // remove comments and env variables
                        if (!self::isComment($cron) && !self::isEnvVariable($cron) && !self::isEmptyLine($cron)){

                            $parsedCron = self::parseCron($cron);
        
                            if (!empty($parsedCron['time'])){
                                $parser = new \Cron\CronExpression($parsedCron['time']);
                            }

                            $list[] = [
                                'user'              => $user,
                                'cron'              => $cron,
                                'timeExpression'    => $parsedCron['time'],
                                'command'           => $parsedCron['command'],
                                'nextRun'           => !empty($parser) ? $parser->getNextRunDate() : '',
                                'nextRunDate'       => !empty($parser) ? $parser->getNextRunDate()->format($dateTimeFormat) : '',
                            ]; 
                        }
                    }
                }
            }
        }


        return $list;
    }
    
    /** 
     * Get systemd timers 
     *
     * @access public
     * @static
     * 
     * @return array
     */
    public static function getSystemTimers(): array
    {
        $list=[];
        if (exec('systemctl list-timers', $timers)){
            
            // remove header
            unset($timers[0]);

            // loop into filtered array
            foreach (array_filter($timers) as $line){
                
                // skip empty line and end comments
                if (self::isEmptyLine($line)) break; 
                
                $line = trim($line);

                /*
                    NEXT                          LEFT          LAST                          PASSED       UNIT                         ACTIVATES
                    Sun 2021-06-20 19:39:00 CEST  12min left    Sun 2021-06-20 19:09:06 CEST  17min ago    phpsessionclean.timer        phpsessionclean.service
                    Mon 2021-06-21 00:00:00 CEST  4h 33min left Sun 2021-06-20 00:00:45 CEST  19h ago      logrotate.timer              logrotate.service
                    Mon 2021-06-21 00:00:00 CEST  4h 33min left Sun 2021-06-20 00:00:45 CEST  19h ago      man-db.timer                 man-db.service
                 */
                
                $expr = '#^'.
                        '(?P<next>[a-zA-Z]+ [0-9\-]+ [0-9:]+ \w+)\s+'.
                        '(?P<left>.+left)\s+'.
                        '(?P<last>[a-zA-Z]+ [0-9\-]+ [0-9:]+ \w+)\s+'.
                        '(?P<passed>.+ago)\s+'.
                        '(?P<unit>[^ ]+)\s+'.
                        '(?P<activates>[^ ]+)'.
                        '#';
                if (preg_match($expr, $line, $matches)) {
                    $parsed = [];
                    foreach (array_filter(array_keys($matches), 'is_string') as $key) {
                        $parsed[$key] = trim($matches[$key]);
                    }
                    $list[] = $parsed;
                }

            }
        }

        return $list;
    }
}