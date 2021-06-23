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

namespace Kristuff\Minitoring\Model\System;

/** 
 * ProcessModel
 */
class ProcessModel extends SystemBaseModel
{


    /** 
     * Get process infos
     *
     * @access public
     * @static
     * 
     * @return array
     */
    public static function getInfos()
    {
        return array(
            'total'     => self::getTotalProcess(),
            'running'   => self::getRunningProcess(),
        );
    }

    /**
     * Returns total process number
     *
     * @access public
     * @static
     *
     * @return int
     */
    public static function getTotalProcess()
    {
        if (!($nb = shell_exec('ps -e h | wc -l'))){
            $nb = 0;
        }
        return intval($nb);
    }

    /**
     * Returns running process number
     *
     * @access public
     * @static
     *
     * @return int
     */
    public static function getRunningProcess()
    {
        if (!($nb = shell_exec('ps r h | wc -l'))){
            $nb = 0;
        }
        return intval($nb);
    }

}
