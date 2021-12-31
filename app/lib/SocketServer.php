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

namespace Kristuff\Minitoring;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Minitoring\Model\Log;
use Kristuff\Minitoring\Model\Services;
use Kristuff\Minitoring;
use Kristuff\Minitoring\Model\TokenCheckerModel;
use Kristuff\Minitoring\Model\System;

class SocketServer implements MessageComponentInterface {

    private $app = null;
    private $appName = 'Minitoring WebSocket Service';

    public function __construct()
    {
        // note: we need an Application instance to make model functions working
        $this->app = new Application();
        $this->clients = new \SplObjectStorage;
        $this->log(LOG_INFO, 'Started');
    }

    public function onOpen(ConnectionInterface $conn) 
    {
        $headers    = $conn->httpRequest->getHeaders();
        $remoteIP   = $headers['X-Forwarded-For'][0];
       
        $this->clients->attach($conn);
        $this->log(LOG_INFO, "New connection established (IP: $remoteIP Client Id: {$conn->resourceId})");
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        //  $querystring = $from->WebSocket->request->getQuery();
        //  $query = $from->httpRequest->getUri()->getQuery();
        //  echo "Minitoring DEBUG query: ". $query . "\n";
        //  file_put_contents('/tmp/minitoring-server.txt', "\n \n \n" . print_r($from->httpRequest, true), FILE_APPEND);
        //  var_dump($from->httpRequest);

        foreach ( $this->clients as $client ){
            if ( $from->resourceId == $client->resourceId ) {
                $response = $this->parseRequest($from, $msg);
                $client->send($response);
                //$client->send( "Client $from->resourceId said $msg test: " );
                break;
            }
            //$client->send( "Client $from->resourceId said $msg" );
        }
    }

    public function onClose(ConnectionInterface $conn) 
    {
        $headers    = $conn->httpRequest->getHeaders();
        $remoteIP   = $headers['X-Forwarded-For'][0];

        $this->clients->detach($conn);
        $this->log(LOG_INFO, "Connection closed (IP: $remoteIP Client Id: {$conn->resourceId})");
    }

    public function onError(ConnectionInterface $conn, \Exception $e) 
    {
        // echo "Minitoring Socket API: Error (Client Id:{$conn->resourceId}, Client Id:{$e->getMessage()}, )\n";
    }

    protected function log(int $facility, string $message): void
    {
        openlog($this->appName, LOG_PERROR | LOG_CONS | LOG_PID, LOG_USER);
        syslog($facility, $message);
        closelog();
    }

    protected function parseRequest(ConnectionInterface $from, string $jsonRequest)
    {
        $response   = TaskResponse::create(400); // the default response (invalid)
        $request    = json_decode(utf8_encode($jsonRequest), true);
        $token      = $request['key'] ?? '';
        $check      = TokenCheckerModel::isTokenValid($token);
        $headers    = $from->httpRequest->getHeaders();
        $remoteIP   = $headers['X-Forwarded-For'][0];

        if (!$check) {
            $this->log(LOG_WARNING, 'Request error: Invalid token from IP [' . $remoteIP . ']');
        }

        if ($response->assertTrue($check, 401, 'Invalid token')) {
            $response = $this->parseCommand($response, $request, $remoteIP);
        }
   
        return json_encode($response->toArray(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }


    protected function parseCommand(TaskResponse $response, array $request, string $remoteIP)
    {
        switch ($request['command']){

            case 'crons':
                $this->log(LOG_INFO, 'Request accepted from IP [' . $remoteIP . '] command [' . $request['command'] . ']');
                $response->setCode(200);
                $response->setData(Minitoring\Model\System\CronTabModel::getAll());
                break;

            case 'logs':
                $this->log(LOG_INFO, 'Request accepted from IP [' . $remoteIP . '] command [' . $request['command'] . ']');
                $logId    = $request['logId'];
                $max      = array_key_exists('maxLines', $request) && is_numeric($request['maxLines']) ? intval($request['maxLines']) : 50;
                $toplineHash = array_key_exists('toplineHash', $request) && 
                                  is_string($request['toplineHash']) && 
                                  !empty($request['toplineHash']) ? $request['toplineHash'] : null;
       
                $lineOffsetHash = array_key_exists('lastlinehash', $request) && 
                                  is_string($request['lastlinehash']) && 
                                  !empty($request['lastlinehash']) ? $request['lastlinehash'] : null;
                
                $response = Log\LogReaderModel::read($logId, $max, $toplineHash, $lineOffsetHash);
                break;

            case 'fail2ban_status':
                $this->log(LOG_INFO, 'Request accepted from IP [' . $remoteIP . '] command [' . $request['command'] . ']');
                $response->setCode(200);
                $response->setData(System\Fail2banModel::getServerInfos());
                break;

            case 'iptables':
                $this->log(LOG_INFO, 'Request accepted from IP [' . $remoteIP . '] command [' . $request['command'] . ']');
                $limit  = isset($request['limit'])  ? intval($request['limit'])  : 0;
                $offset = isset($request['offset']) ? intval($request['offset']) : 0;
                $chain  = isset($request['chain'])  ? $request['chain'] : '';
                $response->setCode(200);
                $response->setData(System\IptablesModel::getIptablesList($chain,$offset, $limit));
                break;

            case 'ip6tables':
                $this->log(LOG_INFO, 'Request accepted from IP [' . $remoteIP . '] command [' . $request['command'] . ']');
                $limit  = isset($request['limit'])  ? intval($request['limit'])  : 0;
                $offset = isset($request['offset']) ? intval($request['offset']) : 0;
                $chain  = isset($request['chain'])  ? $request['chain'] : '';
                $response->setCode(200);
                $response->setData(System\IptablesModel::getIp6tablesList($chain,$offset, $limit));
                break;  
                
            default:
                // invalid command, log error
                $response->assertTrue(false, 400, 'Invalid command');
                $this->log(LOG_ERR, 'Error: Invalid request from IP [' . $remoteIP . '] command [' . $request['command'] . ']');
        }
        return $response;
    }

}