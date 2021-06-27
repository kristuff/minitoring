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

namespace Kristuff\Minitoring\Model;


/** 
 * AppModel
 */
class AppModel extends \Kristuff\Miniweb\Data\Model\DatabaseModel
{

    public static function getAppStats()
    {
        // TODO
        
        //$dbfstats = fstat($file);
        //$data = [
        //    'databaseSizeBytes'  => $fstats['size'],
        //    'databaseSize'       => \Kristuff\Miniweb\Core\Format::getSize($fstats['size']),
        //];

    }
}