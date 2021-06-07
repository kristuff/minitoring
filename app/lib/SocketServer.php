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

namespace Kristuff\Minitoring;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Minitoring\Model\Log;
use Kristuff\Minitoring\Model\Services;
use Kristuff\Minitoring;
use Kristuff\Minitoring\Model\TokenCheckerModel;

class SocketServer implements MessageComponentInterface {

    private $app = null;
    private $appName = 'Minitoring WebSocket Service';

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;

        // server stript is in app/bin folder, root path is the parent folder
        // $rootPath = dirname(get_included_files()[0], 2);
        // note: we need an app instance to make model functions working
        $this->app = new Application();
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
        openlog($this->appName, LOG_PERROR | LOG_CONS, LOG_LOCAL0);
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

        if ($response->assertTrue($check, 403, 'Invalid token')) {
            // Log //TODO
            $this->log(LOG_INFO, 'Request accepted from IP [' . $remoteIP . ']');
            $response = $this->parseCommand($response, $request, $remoteIP);
        }
   
        return json_encode($response->toArray(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }


    protected function parseCommand(TaskResponse $response, array $request, string $remoteIP)
    {
        switch ($request['command']){

            case 'crons':
                $response->setCode(200);
                $response->setData(Minitoring\Model\System\CronTabModel::getAll());
                break;

            case 'logs':
                $logId    = $request['logId'];
                $max      = array_key_exists('maxLines', $request) ? intval($request['maxLines']) : 50;
                $response = Log\LogReaderModel::read($logId, $max);
                break;

            case 'fail2ban_status':
                $response->setCode(200);
                $response->setData(Services\Fail2banModel::getServerInfos());
                break;

            case 'iptables':
                $response->setCode(200);
                $limit  = isset($request['limit'])  ? intval($request['limit'])  : 0;
                $offset = isset($request['offset']) ? intval($request['offset']) : 0;
                $chain  = isset($request['chain'])  ? $request['chain'] : '';
                $response->setData(Services\IptablesModel::getIptablesList($chain,$offset, $limit));
                break;

            case 'ip6tables':
                $response->setCode(200);
                $limit  = isset($request['limit'])  ? intval($request['limit'])  : 0;
                $offset = isset($request['offset']) ? intval($request['offset']) : 0;
                $chain  = isset($request['chain'])  ? $request['chain'] : '';
                $response->setData(Services\IptablesModel::getIp6tablesList($chain,$offset, $limit));
                break;  
                
            default:
                // invalid command, log error
                $response->assertTrue(false, 400, 'Invalid command');
                trigger_error($this->appName . 'request error: Invalid token from IP [' . $remoteIP . ']', E_USER_ERROR);
        }
        return $response;
    }

}