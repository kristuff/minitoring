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

namespace Kristuff\Minitoring\Model\Log;

use Kristuff\Miniweb\Data\Model\DatabaseModel;
use Kristuff\Miniweb\Core\Filter;
use Kristuff\Miniweb\Mvc\Model;
use Kristuff\Minitoring\Model\Monitoring\LogsModel;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Parselog\Software\SoftwareLogParser;
use Kristuff\Parselog\LogParserFactory;
use Kristuff\Miniweb\Core\Format;
use Kristuff\Parselog\LogParser;
use Kristuff\Miniweb\Core\Json;

/** 
 * LogReader class
 */
class LogReader 
{
   
    /** 
     * @var int
     */
    protected $timeoutSeconds = 5; 
    
    /** 
     * @var LogParser
     */
    protected $logParser;

    /** 
     * @var string
     */
    protected $logPath;

    /** 
     * @var 
     */
    protected $file; 

    /** 
     * @var string
     */
    protected $previousLineHash = '';    

    /** 
     * Constructor
     */
    public function __construct(LogParser $parser, string $filePath)
    {
        $this->logParser = $parser;
        $this->logPath = $filePath;
    }

    /**
     * Try to open log file
     * 
     * @access public
     * 
     * @return bool
     */
    public function open(): bool
    {
        $this->file = fopen($this->logPath, "r" );
        return $this->file !== false;
    }

    /**
     * Sets the timeout in seconds.
     * 
     * @access public
     * @param int   $timeout
     * 
     * @return void
     */
    public function setTimeout(int $timeout): void
    {
        $this->timeoutSeconds = $timeout;
    }

    //TODO
    public function setPreviousLineHash(string $hash): void
    {
        $this->previousLineHash = $hash;
    }

    /**
     * Gets new lines (read by the end)
     * TODO:    implement lastlinehash 
     * 
     * @access public
     * @param int   $limit
     * 
     * @return array
     */
    public function getNewLines(int $limit = 100, ?string $lastLineHash = null): array
    {
        $startOffset    = 0;                    // options ?
        $timeoutReached = false;                // indicates if timeout was reached
        $logs           = array();              // the parsed logs lines
        $start          = microtime(true);  
        $linesFound     = 0;
        $linesError     = 0;
        $linesAdded     = 0;
        $newLastLineHash = null;                // the new lastlinehash used later to know if there are new lines
        $fstats         = fstat($this->file);   // use to get infos about file
        
        for ( $x_pos = $startOffset , $ln = 0 , $line = '' , $still = true ; $still ; $x_pos-- ) {
            
            // We have reached the beginning of file
            // Validate the previous read chars by simulating a NL
            if ( fseek( $this->file , $x_pos , SEEK_END ) === -1 ) {
                $still = false;
                $char  = "\n";
            } else {
                // Read a char on a log line
                $char = fgetc( $this->file );
            }
            
            // If the read char if a NL, we need to manage the previous buffered chars as a line
            if ( $char === "\n" ) {

                // Copy the log line as an utf8 line and reset the line for future reads
                $deal = ( mb_check_encoding( $line , 'UTF-8' ) === false ) ? utf8_encode( $line ) : $line;
                $line = '';

                // Manage the new line
                if ( $deal !== '' ) {

                    // Get the last line of the file to compute the hash of this line
                    // Compare to the known lastlinehash
                    $hash = sha1( $deal );
                    if ( empty($newLastLineHash) ) {
                        $newLastLineHash = $hash;
                    }

                    if ( !empty($lastLineHash) && $lastLineHash === $hash ) {
                        break;
                    }    

                    // Parse the new line
                    try {
                        $log = $this->logParser->parse($deal);
                        $logs[] = $log;
                        $linesAdded++;
                    } catch (\Exception $e) {
                        
                        //TODO
                        $linesError++;
                    } finally {
                        $linesFound++;
                    }
                        
                    // Break if we have found the wanted count of logs
                    if ( $linesAdded >= $limit ){
                        break;
                    }
                    
                    // timeout 
                    if ((microtime(true) - $start) >= $this->timeoutSeconds){
                        $timeoutReached = true;
                        break;
                    }
                }

                // continue directly without keeping the \n
                continue;
            }

            // Prepend the read char to the previous buffered chars
            $line = $char . $line;
        }
        
        // release file
        fclose( $this->file );

        return [
            'logs'           => $logs,
            'linesFound'     => $linesFound,
            'linesError'     => $linesError,
            'linesAdded'     => $linesAdded,
            'timeout'        => $timeoutReached,
            'lastLineHash'   => $newLastLineHash,
            'duration'       => (int)( ( microtime( true ) - $start ) * 1000 ),
            'fileSizeBytes'  => $fstats['size'],
            'fileSize'       => Format::getSize($fstats['size']),
            'fileTime'       => $fstats['mtime'], // date de dernière modification (Unix timestamp)
        ];

    }

}  

