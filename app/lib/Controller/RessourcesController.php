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
use Kristuff\Minitoring\Model;
use Kristuff\Miniweb\Auth;

/**
 * 
 */
class RessourcesController extends \Kristuff\Minitoring\PrivateController
{
    /**
     * No default action 
     */
    public function index()
    {
        return false;
    }

    /**
     * Returns a given avatar from private path 
     */
    public function avatar($filename)
    {
        $this->renderImage(Auth\Model\UserAvatarModel::getPath() . $filename);
    }

    /**
     * Render the image
     */
    private function renderImage(string $path)
    {
        $ext =  pathinfo($path, PATHINFO_EXTENSION);
        switch($ext){
            case 'jpeg': 
            case 'jpg': 
                ob_end_clean();
                header('Content-type: image/jpeg');
                header('Content-Length: ' . filesize($path));
                readfile($path);
                break;
            case 'png':
                ob_end_clean();
                header('Content-type: image/png');
                header('Content-Length: ' . filesize($path));
                readfile($path);
                break;
            default:
                //TODO 
                exit;
                //$this->view->renderPng($path);

        }    
    }
}