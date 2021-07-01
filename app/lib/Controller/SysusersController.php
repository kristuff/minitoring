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
 * @version    0.1.10
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Controller;

/**
 * SysUsersController
 */
class SysusersController extends \Kristuff\Minitoring\PrivateController
{
    /** 
     * 
     */
    public function all()
    {
        $this->index();
    }

    /** 
     * 
     */
    public function currents()
    {
        $this->index();
    }

    /** 
     * 
     */
    public function lasts()
    {
        $this->index();
    }

    /** 
     * 
     */
    public function groups()
    {
        $this->index();
    }
}