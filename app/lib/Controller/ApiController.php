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
 * @version    0.1.20
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Controller;

use Kristuff\Miniweb\Http\Request;
use Kristuff\Miniweb\Mvc\TaskResponse;
use Kristuff\Minitoring\Application;
use Kristuff\Minitoring\Model;
use Kristuff\Minitoring\Model\Collection\PingCollectionModel;
use Kristuff\Minitoring\Model\DependencyModel;
use Kristuff\Minitoring\Model\Collection\ServicesCollectionModel;
use Kristuff\Minitoring\Model\System;
use Kristuff\Minitoring\Model\System\PingModel;
use Kristuff\Minitoring\Model\System\ServiceModel;
use Kristuff\Minitoring\Model\TokenCheckerModel;
use Kristuff\Miniweb\Auth\Model\AppSettingsModel;
use Kristuff\Miniweb\Auth\Model\UserLoginModel;

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

    private $appSettings = [];

    /**
     * Constructor
     *
     * @access public
     * @param Application $application        The application instance
     */
    public function __construct(Application $application)
    {
        parent::__construct($application);

        $this->appSettings = AppSettingsModel::getAppSettings();

        // Handle local 
        $lang = $this->session()->get('userSettings')['UI_LANG'];
        if (!empty($lang)){
            $this->application->locales()->setDefault($lang);
        }
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
     * packages api end points
     *
     *  ----------------------------            ------      --------------------------------------------------      
     *  End points                              Method      Description                         
     *  ----------------------------            ------      --------------------------------------------------      
     *  /api/packages                           GET         Get all packages    
     *  /api/packages/all                       GET         Get all packages    
     *  /api/packages/upgradable                GET         Get upgradable packages    
     *  ----------------------------            ------      --------------------------------------------------   
     */
    public function packages($action = null)
    {
        // accept only GET requests
        if ($this->request()->method() === Request::METHOD_GET) {
            switch ($action){
                case '':
                case 'all':
                    $this->response =  TaskResponse::create(200, '', System\PackagesModel::getPackages());
                    break;
                case 'upgradable':
                    $this->response =  TaskResponse::create(200, '', System\PackagesModel::getUpgradablePackages());
                    break;
            }
        }

        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }

    /** 
     * system api end points
     *
     *  ----------------------------            ------      --------------------------------------------------      
     *  End points                              Method      Description                         
     *  ----------------------------            ------      --------------------------------------------------      
     *  /api/system/all                         GET         Get all data from following end points   
     *  /api/system/infos                       GET         Get basics infos about system   
     *  /api/system/cpu                         GET         Get Cpu infos         
     *  /api/system/load                        GET         Get current load average infos
     *  /api/system/memory                      GET         Get current memory infos    
     *  /api/system/swap                        GET         Get current swap infos
     *  /api/system/process                     GET         Get current processes infos
     *  /api/system/disks                       GET         Get disks space infos
     *  /api/system/inodes                      GET         Get inodes usage infos
     *  /api/system/network                     GET         Get network infos    
     *  ----------------------------            ------      --------------------------------------------------   
     */
    public function system($action = null)
    {
        // accept only GET requests
        if ($this->request()->method() === Request::METHOD_GET) {

            switch ($action){

                case 'disks':
                    $showTmpfs      = $this->appSettings['DISKS_SHOW_TMPFS']        ?? false; 
                    $showLoop       = $this->appSettings['DISKS_SHOW_LOOP']         ?? false; 
                    $showFilesystem = $this->appSettings['DISKS_SHOW_FILE_SYSTEM']  ?? false; 
                    $this->response = TaskResponse::create(200, '', System\DiskModel::getInfos($showTmpfs, $showLoop, $showFilesystem));
                    break;

                case 'inodes':
                    $showTmpfs      = $this->appSettings['DISKS_SHOW_TMPFS']        ?? false; 
                    $showLoop       = $this->appSettings['DISKS_SHOW_LOOP']         ?? false; 
                    $showFilesystem = $this->appSettings['DISKS_SHOW_FILE_SYSTEM']  ?? false; 
                    $this->response =  TaskResponse::create(200, '', System\DiskModel::getInodesInfos($showTmpfs, $showLoop, $showFilesystem));
                    break;

                case 'cpu':
                    $showTemp = $this->appSettings['CPU_SHOW_TEMPERATURE'] ?? false; 
                    $this->response = TaskResponse::create(200, '', System\CpuModel::getInfos($showTemp));
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
                    
                //case 'ping':
                //    $this->response = TaskResponse::create(200, '', System\PingModel::getPingResults());
                //    break; 

                case 'network':
                    $this->response = TaskResponse::create(200, '', System\NetworkModel::getNeworkInfos());
                    break;     

                case 'process':
                    $this->response = TaskResponse::create(200, '', System\ProcessModel::getInfos());
                    break;

                case 'infos':
                    $this->response = TaskResponse::create(200, '', System\SystemModel::getInfos());
                    break;        

                case 'all':
                    $showTmpfs = $this->request()->get('tmpfs') ? $this->request()->get('tmpfs') : false; 

                    $this->response = TaskResponse::create(200, '', [
                        'infos'     => System\SystemModel::getInfos(),
                        'network'   => System\NetworkModel::getNeworkInfos(),
                        'process'   => System\ProcessModel::getInfos(),
                        'load'      => System\CpuModel::getLoadAverage(),
                        'swap'      => System\MemoryModel::getSwap(),
                        'memory'    => System\MemoryModel::getMemory(),
                        'cpu'       => System\CpuModel::getInfos(),
                        'disks'     => System\DiskModel::getInfos($showTmpfs),
                        'inodes'    => System\DiskModel::getInodesInfos($showTmpfs),
                        'ping'      => System\PingModel::getPingResults(),
        
                    ]);
                    break;   
            }
        }

        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }

    /** 
     * Logs api end points
     *
     *  ----------------------------            ------      --------------------------------------------------
     *  End points                              Method      Description                    
     *  ----------------------------            ------      --------------------------------------------------
     *  /api/logs                               GET         Get registered log files list   
     *  /api/logs                               POST        Add a log file    
     *  /api/logs/types                         GET         Get registered logtypes         
     *  /api/logs/defaults                      GET         Get default info for each logtype 
     *  /api/logs/formats                       GET         Get registered formats of each logtype        
     *  /api/logs/{logId}                       DELETE      Delete given log file      
     *  /api/logs/{logId}                       POST        Edit given log file           
     *  ----------------------------            ------      --------------------------------------------------
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

                    case 'formats':
                        $data = Model\Log\LogReaderModel::getLogFormats();
                        $this->response = TaskResponse::create(200, '', $data);
                        break;

                    case 'defaults':
                        $data = Model\Log\LogReaderModel::getDefaults();
                        $this->response = TaskResponse::create(200, '', $data);
                        break;

                     case '':
                        $data = Model\Collection\LogsCollectionModel::getList();
                        $this->response = TaskResponse::create(200, '', $data);
                        break;
    
                }
                break;

            case Request::METHOD_POST:
                $logPath            = $this->request()->post('log_path', true) ?? false; 
                $logFormat          = $this->request()->post('log_format', true) ?? false; 
                $logFormatName      = $this->request()->post('log_format_name', true) ?? false; 
                $logType            = $this->request()->post('log_type', true) ?? false; 
                $logName            = $this->request()->post('log_name', true) ?? false; 
                 
                if (empty($param)){
                    $this->response = Model\Collection\LogsCollectionModel::add($logPath,$logType,$logName,$logFormatName,$logFormat);
                } else {
                    $this->response = Model\Collection\LogsCollectionModel::edit(intval($param), $logPath,$logType,$logName,$logFormatName,$logFormat);
                }

                break;

            case Request::METHOD_DELETE:
                $this->response = Model\Collection\LogsCollectionModel::delete(intval($param));
                break;                
        }

        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }

    /** 
     *  sysusers api end points
     * 
     *  ----------------------------            ------      --------------------------------------------------
     *  End points                              Method      Description                    
     *  ----------------------------            ------      --------------------------------------------------
     *  /api/sysusers                           GET         Get system users list   
     *  /api/sysusers/all                       GET         Get system users list   
     *  /api/sysusers/groups                    GET         Get system groups list   
     *  /api/sysusers/current                   GET         Get currents users list   
     *  /api/sysusers/last                      GET         Get last logins    
     *  ----------------------------            ------      --------------------------------------------------
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
                
                case 'current' :
                    $data = System\SystemUsersModel::getCurrentsUsers($limit, $offset);
                    $this->response = TaskResponse::create(200, '', $data);
                    break;

                case 'last' :
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

        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }

    /** 
     *  services api end points  (apply to collection)
     * 
     *  ----------------------------            ------      --------------------------------------------------
     *  End points                              Method      Description                    
     *  ----------------------------            ------      --------------------------------------------------
     *  /api/services                           GET         Get XXXXXXXXXXXXXXXXXX   
     *  /api/services                           POST        XXXXXXXXXXXXXXXXXX   
     *  /api/services/list                      GET         Get XXXXXXXXXXXXXXXXXX   
     *  /api/services/check                     GET         Get XXXXXXXXXXXXXXXXXX   
     *  ----------------------------            ------      --------------------------------------------------
     */
    public function services($action = null)
    {
        switch ($this->request()->method()) {
            case Request::METHOD_GET:
                $data = [];
                
                switch($action){

                    case 'list':
                    case '':
                        if (UserLoginModel::validateAdminPermissions($this->response)){
                            $data['items'] = ServicesCollectionModel::getServicesList(-1, true);
                            $this->response->setCode(200);
                            $this->response->setData($data);
                        }
                        break;

                    case 'check':
                        $showPortNumber = $this->appSettings['SERVICES_SHOW_PORT_NUMBER'] ?? false; 
                        $data['items']  = ServiceModel::getCheckedServicesList($showPortNumber);
                        $this->response = TaskResponse::create(200, '', $data);
                        break;
                }
                break;

            case Request::METHOD_POST:
                $serviceName        = $this->request()->post('service_name', true) ?? ''; 
                $serviceHost        = $this->request()->post('service_host', true) ?? ''; 
                $servicePort        = $this->request()->post('service_port', true) ? intval($this->request()->post('service_port')) : null; 
                $serviceProtocol    = $this->request()->post('service_protocol' , true) ?? 'tcp'; 
                $serviceCheckPort   = $this->request()->post('service_check_port', true) ? 1 : 0 ; 
                $this->response = ServicesCollectionModel::add($serviceName, $serviceHost, $servicePort, $serviceCheckPort, $serviceProtocol);
                break;
         }

        // render
        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }

    /** 
     *  service api end points (apply to an item)
     * 
     *  ----------------------------            ------      --------------------------------------------------
     *  End points                              Method      Description                    
     *  ----------------------------            ------      --------------------------------------------------
     *  /api/services/{id}                      DELETE      Delete service
     *  /api/services/{id}                      POST        Edit service
     *  /api/services/{id}/enable               PUT         Enable service check    
     *  /api/services/{id}/disable              PUT         Disable service check  
     *  ----------------------------            ------      --------------------------------------------------
     */
    public function service($serviceId = null, $action = null)
    {
        if (is_numeric($serviceId)){
            $serviceId = intval($serviceId);

            switch ($this->request()->method()) {
                        
                case Request::METHOD_PUT:
                    switch($action){
                        case 'enable':
                            $this->response = ServicesCollectionModel::setCheckState($serviceId, 1);
                            break;

                        case 'disable':
                            $this->response = ServicesCollectionModel::setCheckState($serviceId, 0);
                            break;
                    }
                    break;
                
                case Request::METHOD_DELETE:
                    $this->response = ServicesCollectionModel::delete($serviceId);
                    break;

                case Request::METHOD_POST:
                    $serviceName        = $this->request()->post('service_name', true) ?? ''; 
                    $serviceHost        = $this->request()->post('service_host', true) ?? ''; 
                    $servicePort        = $this->request()->post('service_port', true) ? intval($this->request()->post('service_port')) : null; 
                    $serviceProtocol    = $this->request()->post('service_protocol' , true) ?? 'tcp'; 
                    $serviceCheckPort   = $this->request()->post('service_check_port', true) ? 1 : 0 ; 
                    $this->response = ServicesCollectionModel::edit($serviceId, $serviceName, $serviceHost, $servicePort, $serviceCheckPort, $serviceProtocol);
                    break;

            }
        }

        // render
        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }

    /** 
     *  services api end points  (apply to collection)
     * 
     *  ----------------------------            ------      --------------------------------------------------
     *  End points                              Method      Description                    
     *  ----------------------------            ------      --------------------------------------------------
     *  /api/services                           GET         Get XXXXXXXXXXXXXXXXXX   
     *  /api/services                           POST        XXXXXXXXXXXXXXXXXX   
     *  /api/services/list                      GET         Get XXXXXXXXXXXXXXXXXX   
     *  /api/services/check                     GET         Get XXXXXXXXXXXXXXXXXX   
     *  ----------------------------            ------      --------------------------------------------------
     */
    public function pings($action = null)
    {
        switch ($this->request()->method()) {
            case Request::METHOD_GET:
                $data = [];
                
                switch($action){

                    case 'list':
                    case '':
                        if (UserLoginModel::validateAdminPermissions($this->response)){
                            $data['items'] = PingCollectionModel::getList(-1, true);
                            $this->response->setCode(200);
                            $this->response->setData($data);
                        }
                        break;

                    case 'check':
                        $data['items']  = PingModel::getPingResults();
                        $this->response = TaskResponse::create(200, '', $data);
                        break;
                }
                break;

            case Request::METHOD_POST:
                $host        = $this->request()->post('ping_host', true) ?? ''; 
                $this->response = PingCollectionModel::add($host);
                break;
         }

        // render
        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }



    /** 
     *  ping api end points (apply to an item)
     * 
     *  ----------------------------            ------      --------------------------------------------------
     *  End points                              Method      Description                    
     *  ----------------------------            ------      --------------------------------------------------
     *  /api/services/{id}                      DELETE      Delete service
     *  /api/services/{id}                      POST        Edit service
     *  /api/services/{id}/enable               PUT         Enable service check    
     *  /api/services/{id}/disable              PUT         Disable service check  
     *  ----------------------------            ------      --------------------------------------------------
     */
    public function ping($hostId = null, $action = null)
    {
        if (is_numeric($hostId)){
            $hostId = intval($hostId);

            switch ($this->request()->method()) {
                        
                case Request::METHOD_PUT:
                    switch($action){
                        case 'enable':
                            $this->response = PingCollectionModel::setCheckState($hostId, 1);
                            break;

                        case 'disable':
                            $this->response = PingCollectionModel::setCheckState($hostId, 0);
                            break;
                    }
                    break;
                
                case Request::METHOD_DELETE:
                    $this->response = PingCollectionModel::delete($hostId);
                    break;

                case Request::METHOD_POST:
                    $host        = $this->request()->post('ping_host', true) ?? ''; 
                    $this->response = PingCollectionModel::edit($hostId, $host);
                    break;

            }
        }

        // render
        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }


    /** 
     *  app api end points
     * 
     *  ----------------------------            ------      --------------------------------------------------
     *  End points                              Method      Description                    
     *  ----------------------------            ------      --------------------------------------------------
     *  /api/app/auth                           GET         Get the websocket token   
     *  /api/app/auth                           DELETE      Reset the websocket token (get a new key)   
     *  /api/app/settings                       POST        Update settings parameter value
     *  /api/app/packages                       GET         Get installed packages from composer.lock   
     *  /api/app/feedback                       GET         Get (and clear) internal feedbacks from Models   
     *  ----------------------------            ------      --------------------------------------------------
     */
    public function app($action = '')
    {  
        switch ($this->request()->method()) {
            case Request::METHOD_GET:
            
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
                        $feedbacks      =  Model\SetupModel::feedback();
                        $this->response = TaskResponse::create(200, null, [
                            'feedbackNegatives' => $feedbacks->getNegatives(),
                            'feedbackPositives' => $feedbacks->getPositives(),
                        ]);
                        // reset after printing messages
                        $feedbacks->clear();
                        break;
                }
                break;
            
            case Request::METHOD_POST:
                switch($action){

                    case 'settings':
                        $param = $this->request()->post('parameter', true)  ?? null;  
                        $value = $this->request()->post('value', true)      ?? null;
                        $this->response = AppSettingsModel::editAppSettings($param, $value, $this->token, $this->tokenKey); 
                        break;
                }
                break;

            case Request::METHOD_DELETE:
                switch($action){

                    case 'auth':
                        $this->response =TokenCheckerModel::resetToken();
                        break;
                }
                break;
        }
        
        $this->view->renderJson($this->response->toArray(), $this->response->code());
    }
}