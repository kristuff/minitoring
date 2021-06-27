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

namespace Kristuff\Minitoring\Controller;

use Kristuff\Minitoring\Application;
use Kristuff\Minitoring\Model\AppModel;
use Kristuff\Minitoring\View;

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

    }
}