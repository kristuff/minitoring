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
 * @version    0.1.2
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring;

use Kristuff\Miniweb\Http\Server;
use Kristuff\Miniweb\Auth\Model\UserLoginModel;
use Kristuff\Minitoring\PublicController;
use Kristuff\Miniweb\Auth;

/**
 * Class PrivateController
 *
 * Extends Auth\Controller\MustLoggedController for logged in users.
 * A no loged user will be redirect to login page
 */
class PrivateController extends \Kristuff\Miniweb\Auth\Controller\PrivateController
{
    /**
     * Constructor
     *
     * @access public
     * @param Application $application        The application instance
     */
    public function __construct(Application $application)
    {
        /** 
         * --------------------------------------
         * Do NOT init parent NOW
         * we need do check for redirect to setup before parent construct to avoid 
         * infinite redirect to login
         */ 
         //   parent::__construct(); /

         // check for redirect to setup
        if (!Model\SetupModel::isInstalled() && $this->request()->controllerName() != 'setup'){
            \Kristuff\Miniweb\Http\Redirect::url(Application::getUrl() . 'setup', false, true);
        }

        // no redirect, so init parent
        parent::__construct($application);
     
        // use a derived version of view
        $this->view = new View();

        // load minimal user data. include api token
        foreach (UserLoginModel::getPostLoginData() as $key => $value){
            $this->view->setData($key, $value);
        }

        // load user settings
        foreach ($this->session()->get('userSettings') as $key => $value){
            $this->view->setData($key, $value);
        }

        // Handle local 
        $lang = $this->session()->get('userSettings')['UI_LANG'];
        if (!empty($lang)){
            $this->application->locales()->setDefault($lang);
        }

        // set commn data
        $this->view->setData('APP_NAME',        Application::config('APP_NAME')); 
        $this->view->setData('APP_COPYRIGHT',   Application::config('APP_COPYRIGHT')); 
        $this->view->setData('APP_VERSION',     Application::config('APP_VERSION')); 
     
        // needed for ajax navigation
        $viewId =  $this->request()->controllerName();
        $viewId .= (empty($this->request()->actionName()) || $this->request()->actionName() === 'index') ? '' : '/'. $this->request()->actionName();
        $this->view->setData('viewId', $viewId);
        $this->view->setData('currentView',     $this->request()->controllerName());
        $this->view->setData('currentAction',   $this->request()->actionName());

        // other data
        $this->view->setData('installedPackages', \Kristuff\Minitoring\Model\DependencyModel::getDependencies());
        $this->view->setData('websocketToken', \Kristuff\Minitoring\Model\TokenCheckerModel::getOrCreateToken());

    }

    /** 
     * Index: Default view for each controller
     */
    public function index()
    {
        $this->view->renderHtml('main/index.view.php', [], 'main');
    }
}