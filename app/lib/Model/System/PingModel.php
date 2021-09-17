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

namespace Kristuff\Minitoring\Model\System;

use Kristuff\Minitoring\Model\Collection\PingCollectionModel;
use Kristuff\Patabase\Database;
use Kristuff\Patabase\Output;

/** 
 * PingModel
 */
class PingModel extends SystemBaseModel
{
    /**
     * Get ping stats for given domains
     * 
     * @access public
     * @static
     * 
     * @return array
     */
    public static function getPingResults(): array
    {  
        $hosts = PingCollectionModel::getList(1);
        return self::pingHosts($hosts);
    }



    /**
     * Get ping stats for given domains
     * 
     * @access public
     * @static
     * @param array     $hosts      The hosts to check
     * 
     * @return array
     */
    public static function pingHosts(array $hosts): array
    {   
        $data = array();

        foreach ($hosts as $host)
        {
            $host = $host['ping_host'];
            exec('/bin/ping -qc 1 '.$host.' | awk -F/ \'/^(rtt|round-trip)/ { print $5 }\'', $result);

            if (!isset($result[0])){
                $result[0] = 0;
            }
            
            $data[] = array(
                'host' => $host,
                'ping' => $result[0],
            );

            unset($result);
        }
        return $data;
    }

}