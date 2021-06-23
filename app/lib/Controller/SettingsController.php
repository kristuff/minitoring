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
 * @version    0.1.5
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Controller;

use Kristuff\Miniweb\Auth\Model\UserAvatarModel;


/**
 * SettingsController
 */
class SettingsController extends \Kristuff\Minitoring\PrivateController
{
    /** 
     * 
     */
    public function about()
    {
        $this->index();
    }

    /** 
     * 
     */
    public function customize()
    {
        $this->index();
    }

    /** 
     * App data
     */
    public function data()
    {
        $this->index();
    }

    /** 
     * App users
     */
    public function users()
    {
        $this->index();
    }

    /** 
     * 
     */
    public function advanced()
    {
        $this->index();
    }
    
    /** 
     * Profile
     */
    public function profile()
    {
        $this->index();
    }
       
    /** 
     * logreader
     */
    public function logreader()
    {
        $this->index();
    }

    /** 
     * logreader
     */
    public function services()
    {
        $this->index();
    }

     /** 
     * bans
     */
    public function bans()
    {
        $this->index();
    }
}