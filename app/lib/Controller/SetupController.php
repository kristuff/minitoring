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

namespace Kristuff\Minitoring\Controller;

use Kristuff\Minitoring\Model;
use Kristuff\Minitoring\Application;

/**
 * SetupController
 */
class SetupController extends \Kristuff\Miniweb\Auth\Controller\BaseController
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

        // prevent access to this controller when app is already installed
        if (Model\SetupModel::isInstalled()){
            $this->redirecthome();
        }

        // use a derived version of view
        $this->view = new \Kristuff\Minitoring\View();

        // set commn data
        $this->view->setData('APP_NAME',        Application::config('APP_NAME')); 
        $this->view->setData('APP_COPYRIGHT',   Application::config('APP_COPYRIGHT')); 
        $this->view->setData('APP_VERSION',     Application::VERSION); 

        $language = Application::config('APP_LANGUAGE');
        $this->view->setData('APP_LANGUAGE',     $language); 
        $this->view->setData('CURRENT_LANGUAGE', $language); 

        if (!empty($language)){
            $application->locales()->setDefault($language);
        }
    
        // possible language overwrite with query string
        $lang = $this->request()->arg('language');
        if (!empty($lang) && in_array($lang, ['fr-FR','en-US'])){
            $this->view->setData('CURRENT_LANGUAGE', $lang); 
            $application->locales()->setDefault($lang);
        }
    } 

    /** 
     * 
     */
    public function index()
    {
        $this->view->renderHtml('setup/setup.view.php', [], 'setup');
    }

    /** 
     * 
     */
    public function check()
    {
        $response = Model\SetupModel::checkForInstall();
        $this->view->renderJson($response->toArray(), $response->code());
    }

    /** 
     * 
     */
    public function install()
    {
        $adminName =     $this->request()->post('admin_name')     ? $this->request()->post('admin_name', true)  : ''; 
        $adminPassword = $this->request()->post('admin_password') ? $this->request()->post('admin_password')    : ''; 
        $adminEmail =    $this->request()->post('admin_email')    ? $this->request()->post('admin_email', true) : ''; 
        $databaseName =  $this->request()->post('db_name')        ? $this->request()->post('db_name', true)     : '';        
        $language =      $this->request()->post('language')       ? $this->request()->post('language', true)    : '';        
        //TODO $databaseName =  $this->request()->post('db_name')        ? $this->request()->post('db_name', true)     : '';        

        $response = Model\SetupModel::install(
            $databaseName,
            $adminName, 
            $adminPassword, 
            $adminEmail,
            $language 
        );
        $this->view->renderJson($response->toArray(), $response->code());
    }
}