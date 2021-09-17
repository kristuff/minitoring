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

namespace Kristuff\Minitoring\Controller;

use Kristuff\Minitoring\Application;

/**
 * IndexController
 */
class IndexController extends \Kristuff\Minitoring\PrivateController
{
    /** 
     * Index: Default (and unique) view for this controller
     * 
     * Redirect to dashboard
     * This is done to prevent issues with client side navigation when
     * main view has no explicit name 
     * 
     */
    public function index()
    {
        $this->redirect(Application::getUrl() .'overview');
    }
}