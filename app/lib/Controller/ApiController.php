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

namespace Kristuff\Minitoring\Controller;

use Kristuff\Miniweb\Http\Request;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Minitoring\Application;
use Kristuff\Minitoring\Model;
use Kristuff\Minitoring\Model\DependencyModel;
use Kristuff\Minitoring\Model\System;
use Kristuff\Minitoring\Model\System\ServiceModel;
use Kristuff\Minitoring\Model\TokenCheckerModel;

/** 
 * Class Api Controller
 * This controller contains methods to access/control application data
 * 
 * Possible response codes and outpout format by method:
 * 
 *  -------------                      ---     ----    ---     ------      ------
 *  Response code                      GET     POST    PUT     DELETE      format
 *  -------------                      ---     ----    ---     ------      ------
 *  200 (OK)                            X       -       X        -          JSON
 *  201 (Created)                       -       X       -        -          JSON
 *  400 (bad requests)                  X       X       X        X          JSON
 *  401 (not allowed, require login)    X       X       X        X          JSON
 *  403 (not allowed, denied)           X       X       X        X          JSON
 *  405 (Method Not Allowed)            X       X       X        X          JSON
 *  500 (internal error)                X       X       X        X          JSON
 *  -------------                      ---     ----    ---     ------      ------
 * 
 */
class ApiController extends \Kristuff\Miniweb\Auth\Controller\ApiController
{
    /**
     * Constructor
     *
     * @access public
     * @param Application $application        The application instance
     */
    public function __construct(Application $application)
    {
        parent::__construct($application);

        // Handle local 
        $lang = $this->session()->get('userSettings')['UI_LANG'];
        $this->application->locales()->setDefault($lang);
    }
    
    /** 
     * Default controller returns an error 
     * 
     * @access private
     * @return void/json       
     */
    public function index()
    {
        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }

    /** 
     * System api end points
     *
     *  ----------------------------            ------      ------------------------------      --------------------    -------------------------
     *  End points                              Method      Description                         parameters(s)           Response
     *  ----------------------------            ------      ------------------------------      --------------------    -------------------------
     *  /api/system/all                         GET         Get all data from following end points   
     *  /api/system/infos                       GET         Basics infos about system   
     *  /api/system/cpu                         GET         Cpu infos         
     *  /api/system/load                        GET         Current load infos
     *  /api/system/memory                      GET         Current memory infos    
     *  /api/system/swap                        GET         Current swap infos
     *  /api/system/disks                       GET         Disks space infos
     *  /api/system/inodes                      GET         Inodes usage infos
     *  ----------------------------            ------      ------------------------------      --------------------    -------------------------
     */
    public function system($action = null)
    {
        // accept only GET requests
        if ($this->request()->method() === Request::METHOD_GET) {

            switch ($action){

                case 'disks':
                    $showTmpfs = $this->request()->get('tmpfs') ? $this->request()->get('tmpfs') : false; 
                    $this->response =  TaskResponse::create(200, '', System\DiskModel::getInfos($showTmpfs));
                    break;

                case 'inodes':
                    $showTmpfs = $this->request()->get('tmpfs') ? $this->request()->get('tmpfs') : false; 
                    $this->response =  TaskResponse::create(200, '', System\DiskModel::getInodesInfos($showTmpfs));
                    break;

                case 'cpu':
                    $this->response = TaskResponse::create(200, '', System\CpuModel::getInfos());
                    break;        

                case 'memory':
                    $this->response = TaskResponse::create(200, '', System\MemoryModel::getMemory());
                    break; 
                    
                case 'swap':
                    $this->response = TaskResponse::create(200, '', System\MemoryModel::getSwap());
                    break;    

                case 'load':
                    $this->response = TaskResponse::create(200, '', System\CpuModel::getLoadAverage());
                    break;    
                    
                case 'network':
                    $this->response = TaskResponse::create(200, '', System\NetworkModel::getNeworkInfos());
                    break;     

                case 'infos':
                    $this->response = TaskResponse::create(200, '', System\SystemModel::getInfos());
                    break;        

                case 'all':
                    $showTmpfs = $this->request()->get('tmpfs') ? $this->request()->get('tmpfs') : false; 

                    $this->response = TaskResponse::create(200, '', [
                        'infos'     => System\SystemModel::getInfos(),
                        'network'   => System\NetworkModel::getNeworkInfos(),
                        'load'      => System\CpuModel::getLoadAverage(),
                        'swap'      => System\MemoryModel::getSwap(),
                        'memory'    => System\MemoryModel::getMemory(),
                        'cpu'       => System\CpuModel::getInfos(),
                        'disks'     => System\DiskModel::getInfos($showTmpfs),
                        'inodes'    => System\DiskModel::getInodesInfos($showTmpfs),
                    ]);
                    break;   
            }
        }

        // render
        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }

    /** 
     * Logs api end points
     *
     *  ----------------------------            ------      ------------------------------      --------------------    -------------------------
     *  End points                              Method      Description                         parameters(s)           Response
     *  ----------------------------            ------      ------------------------------      --------------------    -------------------------
     *  /api/logs                               GET            
     *  /api/logs                               POST            
     *  /api/logs/types                         GET                 
     *  /api/logs/defaults                      GET                 
     *  /api/logs/{logId}                       DELETE      Delete given log file      
     *  /api/logs/{logId}                       POST        Edit given log file           
     *  ----------------------------            ------      ------------------------------      --------------------    -------------------------
     */
    public function logs($param = '')
    {  
        switch ($this->request()->method()) {
            case Request::METHOD_GET:
                switch ($param) {
                    case 'types':
                        $data = Model\Log\LogReaderModel::getLogTypes();
                        $this->response = TaskResponse::create(200, '', $data);
                        break;
                    case 'defaults':
                        $data = Model\Log\LogReaderModel::getDefaults();
                        $this->response = TaskResponse::create(200, '', $data);
                        break;
                     case '':
                        $data = Model\Log\LogsCollectionModel::getList();
                        $this->response = TaskResponse::create(200, '', $data);
                        break;
    
                }
                break;

            case Request::METHOD_POST:
                $logPath    = $this->request()->post('log_path', true) ?? false; 
                $logFormat  = $this->request()->post('log_format', true) ?? false; 
                $logType    = $this->request()->post('log_type', true) ?? false; 
                $logName    = $this->request()->post('log_name', true) ?? false; 
                
                if (empty($param)){
                    $this->response = Model\Log\LogsCollectionModel::add($logPath,$logType,$logName,$logFormat);
                } else {
                    $this->response = Model\Log\LogsCollectionModel::edit(intval($param), $logPath,$logType,$logName,$logFormat);
                }

                break;

            case Request::METHOD_DELETE:
                $this->response = Model\Log\LogsCollectionModel::delete(intval($param));
                break;                
        }

        // render
        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }

    /** 
     *  System users api
     */
    public function sysusers($action = '')
    {  
        // accept only GET requests
        if ($this->request()->method() === Request::METHOD_GET) {

            // todo
            $limit  = $this->request()->arg('limit')  ? (int) $this->request()->arg('limit')  : 20; 
            $offset = $this->request()->arg('offset') ? (int) $this->request()->arg('offset') : 0; 
            
            switch($action){
                case 'currentUsersNumber' :
                     $this->response = TaskResponse::create(200, '', 
                        ['currentUsersNumber' =>System\SystemUsersModel::getCurrentUsersNumber()]);
                    break;
                
                case 'currents' :
                    $data = System\SystemUsersModel::getCurrentsUsers($limit, $offset);
                    $this->response = TaskResponse::create(200, '', $data);
                    break;

                case 'lasts' :
                    $data = System\SystemUsersModel::getUsers(true, $limit, $offset);
                    $this->response = TaskResponse::create(200, '', $data);
                    break;

                case 'groups' :
                    $data = System\SystemUsersModel::getGroups($limit, $offset);
                    $this->response = TaskResponse::create(200, '', $data);
                    break;

                case 'all':
                case '':
                default:
                    $data = System\SystemUsersModel::getAllUsers($limit, $offset);
                    $this->response = TaskResponse::create(200, '', $data);
                    break;        
            }
        }

        // render
        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }

   /** 
    *  Services api
    */
    public function services($action = null, $serviceId = null)
    {
        switch ($this->request()->method()) {
            case Request::METHOD_GET:
                $data = [];
                $limit  = $this->request()->arg('limit')  ? (int) $this->request()->arg('limit')  : 50; 
                $offset = $this->request()->arg('offset') ? (int) $this->request()->arg('offset') : 0; 
                
                switch($action){

                    case 'list':
                    case '':
                        $data['items'] = ServiceModel::getCheckedServicesList();
                        break;

                    case 'check':
                        $data['total']  = ServiceModel::countChecks($serviceId); 
                        $data['limit']  = $limit; 
                        $data['offset'] = $offset; 
                        $data['items']  = ServiceModel::getLastChecks($serviceId, $action !== 'history', $limit, $offset);
                        break;
                }
                $this->response = TaskResponse::create(200, '', $data);
                break;

            case 'POST':
                //todo
                break;
            
            case 'PUT':
                switch($action){
                    case 'activate':
                        //TODO admin
                       // $this->view->renderJson(SystemModel::createResponse(200, '', ServiceModel::setCheckState($serviceId, 1)));
                        break;
                    case 'desactivate':
                        //TODO admin ... CODE
                     //   $this->view->renderJson(SystemModel::createResponse(200, '', ServiceModel::setCheckState($serviceId, 0)));
                        break;
                }
                break;
            
            case 'DELETE':
                break;
         }

        // render
        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }

    /** 
     *  app api
     */
    public function app($action = '')
    {  
        // accept only GET requests
        if ($this->request()->method() === Request::METHOD_GET) {
            
            switch($action){

                case 'auth':
                    $data =  ['key' => TokenCheckerModel::getOrCreateToken()];
                    $this->response = TaskResponse::create(200, null, $data);
                    break;
                
                case 'packages':
                    $data =  ['packages' => DependencyModel::getDependencies()];
                    $this->response = TaskResponse::create(200, null, $data);
                    break;
                    
                case 'feedback':
                    // the feedback function is available in any Model 
                    $feedbacks =  Model\AppModel::feedback();
                    $this->response = TaskResponse::create(200, null, [
                        'feedbackNegatives' => $feedbacks->getNegatives(),
                        'feedbackPositives' => $feedbacks->getPositives(),
                    ]);
                    // reset after printing messages
                    $feedbacks->clear();
                    break;
            }
        }
        
        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }
  
}