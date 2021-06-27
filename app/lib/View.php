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

use Kristuff\Minitoring\Application;
use Kristuff\Minitoring\Model;

/**
 * Class View
 *
 * Extends Miniweb\Mvc\View with custom rendering functionality
 */
class View extends \Kristuff\Miniweb\Mvc\View
{
    //todo
    protected $title = ''; 
    protected $baseUrl = '';
    protected $feedbackPositives = [];
    protected $feedbackNegatives = [];
    
    //TODO
    public function __construct()
    {
       $this->title =   Application::config('APP_NAME'); 
       $this->baseUrl = Application::getUrl();
    }
  
    public function echo(string $key, ?string $locale = null)
    {
        $text = $this->text($key, $locale);
        echo $text;
    }  


    //TODO doc
    public function renderFeedback()
    {
        // the feedback function is available in any Model 
        $feedbacks =  Model\SetupModel::feedback();

        if (count($feedbacks->getPositives()) + count($feedbacks->getNegatives()) > 0 ){
            
            // register feedbacks in private variables to be available in the rendered view, 
            // then render the feedbacks
            $this->feedbackNegatives = $feedbacks->getNegatives();
            $this->feedbackPositives = $feedbacks->getPositives();
            $this->includeFile('misc/feedback.view.php');

            // reset after printing messages
            $feedbacks->clear();
            $this->feedbackNegatives = [];
            $this->feedbackPositives = [];
        }
    }
}