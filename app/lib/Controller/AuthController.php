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
 * @version    0.1.11
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Controller;

use Kristuff\Minitoring\Application;
use Kristuff\Minitoring\Model\AppModel;
use Kristuff\Minitoring\Model\SetupModel;
use Kristuff\Minitoring\View;
use Kristuff\Miniweb\Auth\Model\AppSettingsModel;

/**
 * Class AuthController
 *
 */
class AuthController extends \Kristuff\Miniweb\Auth\Controller\AuthController
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
        if (!SetupModel::isInstalled() && $this->request()->controllerName() != 'setup'){
            \Kristuff\Miniweb\Http\Redirect::url(Application::getUrl() . 'setup', false, true);
        }

        // no redirect, so init parent
        parent::__construct($application);

        // use a derived version of view
        $this->view = new View();

        // set commn data
        $this->view->setData('APP_NAME',        Application::config('APP_NAME')); 
        $this->view->setData('APP_COPYRIGHT',   Application::config('APP_COPYRIGHT')); 
        $this->view->setData('APP_VERSION',     Application::config('APP_VERSION')); 
  

        $appSettings = AppSettingsModel::getAppSettings();
        $language = $appSettings['UI_LANG'];

        // set default language 
        $language = isset($language) && in_array($language, ['fr-FR','en-US']) ? $language : Application::config('APP_LANGUAGE');
        if (!empty($language)){
            $application->locales()->setDefault($language);
        }

    }
}