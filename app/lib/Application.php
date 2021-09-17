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
 * @version    0.1.19
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring;

use Kristuff\Miniweb\Mvc;
use Kristuff\Minitoring\Model;

/**
 * Class Application
 *
 * The heart of the application
 */
class Application extends Mvc\Application
{

    /** 
     * current version 
     */
    const VERSION = "v0.1.19";

    /** 
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        // load locales
        $this->locales()->registerAutoloader(__DIR__ . '/../locales', ['en-US', 'fr-FR'], 'locale.php');
        $this->locales()->setDefault('en-US');
 
        // Use custom sessionHandler ?
        
        // use the default language for output
        shell_exec('export LC_ALL=C');
    }

    /** 
     * Load internal config
     */
    public function loadLocalConfig(): void
    {
        // Now adjust and set minimal Miniweb config and this app config
        // allow simple overwite of some config data in a '.config.local.php'
        // if file exists: Extract data and complete or overwrite default config
        $this->loadConfigFile(__DIR__ . '/../config/minitoring.conf.php');
        $this->loadConfigFile(__DIR__ . '/../config/minitoring.conf.local.php');
       
        // load database config
        if (Model\SetupModel::isInstalled()){
            $this->setConfig(Model\SetupModel::getConfig());
        }
    }

    /** 
     * Handles the 404 not found
     *
     * @access public
     * @return mixed
     */
    public function handleError404()
    {
        // note that 404 header is already set by Application
        // we need to create an error controller to render a custom view
        $controller = new \Kristuff\Minitoring\ErrorController($this);
        $controller->error404();
    }

    /** 
     * Handles the server error
     *
     * @access public
     * @return mixed
     */
    public function handleError500()
    {
        // note that 500 header is already set by Application
        // we need to create an error controller to render a custom view
        $controller = new \Kristuff\Minitoring\ErrorController($this);
        $controller->error500();
    }
}