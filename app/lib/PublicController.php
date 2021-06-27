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
 * @version    0.1.7
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring;

use Kristuff\Minitoring\Model;
use Kristuff\Minitoring\View;
use Kristuff\Minitoring\Application;
use Kristuff\Minitoring\Model\AppModel;

/**
 * Class PublicController
 * All users accessible (logged in or not) base controller
 * Extends Miniweb\Mvc\Auth\Controller\PublicController with auth functionality and custom View
 */
abstract class PublicController extends \Kristuff\Miniweb\Auth\Controller\BaseController
{
    /**
     * Constructor
     *
     * @access public
     * @param Application $application        The application instance
     */
    public function __construct(Application $application)
    {
          // init parent 
        parent::__construct($application);

        // use a derived version of view
        $this->view = new View();

        // set commn data
        $this->view->setData('APP_NAME',        Application::config('APP_NAME')); 
        $this->view->setData('APP_COPYRIGHT',   Application::config('APP_COPYRIGHT')); 
        $this->view->setData('APP_VERSION',     Application::config('APP_VERSION')); 

        // set default language 
        $language = Application::config('APP_DEFAULT_LANGUAGE');
        if (!empty($language)){
            $application->locales()->setDefault($language);
        }

        /** 
         * *************************** 
         * check for redirect to setup
         * *************************** 
         */ 
        if (!Model\SetupModel::isInstalled() && $this->request()->controllerName() != 'setup'){
            \Kristuff\Miniweb\Http\Redirect::url(Application::getUrl() . 'setup', false, true);
        }
    }
}