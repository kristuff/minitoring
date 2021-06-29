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
 * @version    0.1.8
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model\Services;

use Kristuff\Miniweb\Data\Model\DatabaseModel;

/** 
 *
 */
class IptablesModel extends DatabaseModel
{


    public static function getIptablesList(string $chain = '', int $offset = 0, int $limit = 0): array
    {
        if (exec('iptables -nL --line-numbers', $iptables)){
            return self::parseIptablesChains(array_filter($iptables), $chain, $offset, $limit );
        }

        return [];
    }

    public static function getIp6tablesList(string $chain = '', int $offset = 0, int $limit = 0): array
    {
        if (exec('ip6tables -nL --line-numbers', $iptables)){
            return self::parseIptablesChains(array_filter($iptables), $chain, $offset, $limit );
        }

        return [];
    }

    /**
     * Parse raw iptables data into array.
     *
     * @access public
     * @static
     * @param array     $data       
     * @param string    $wantedChain        
     * 
     * @return array
     */
    public static function parseIptablesChains(array $data, string $wantedChain = '', int $offset = 0, int $limit = 0, bool $banOnly = false) : array
    {
        $index = 0;
        $count = 0;
        $result = [];
        $patterns = [
            'chain' => '/(?:Chain\s)
                        (?<chain>[^\s]+)
                        (?:.*\()
                        (?<policy>.*)
                        (?:\).*)/x',

            'rule' => '/(?<id>\d+)\s+
                        (?<target>[\w\-_]+)\s+
                        (?<protocol>\w+)\s+
                        (?<opt>[\w-]+|)\s+
                        (?<source>[0-9\.:a-zA-Z\/]+)\s+
                        (?<destination>[0-9\.:a-zA-Z\/]+)\s+
                        (?<options>.*|)/x'

//            'rule' => '/(?<id>\d+)\s+
//                        (?<target>[\w\-_]+)\s+
//                        (?<protocol>\w+)\s+
//                        (?<opt>[\w-]+)\s+
//                        (?<source>[0-9\.\/]+)\s+
//                        (?<destination>[0-9\.\/]+)\s+
//                        (?<options>.*|)/x'
        ];

        foreach ($data as $row) {
            
            if (preg_match($patterns['chain'], $row, $out)) {

                $chain = $out['chain'];
                
                if (empty($wantedChain) || $chain === $wantedChain){
                    $result['chains'][] = [
                        'chain'  =>  $chain,
                        'policy' =>  $out['policy'],
                        'rules'  => [],
                    ];
                    continue;
                }
            }

            if (isset($chain) && preg_match($patterns['rule'], $row, $out)) {

                // filter by chain
                if (empty($wantedChain) || $chain === $wantedChain){

                    // offset?
                    if ($offset > 0 && $index < $offset){
                        continue;
                    }

                    $target = $out['target'];
                    if ($banOnly && $target !== 'DROP' && $target !== 'REJECT'){
                        continue;
                    } 

                    $result['chains'][array_key_last($result['chains'])]['rules'][] = [
                        'target'        => $out['target'], 
                        'protocol'      => $out['protocol'], 
                        'source'        => $out['source'], 
                        'destination'   => $out['destination'], 
                        'options'       => trim($out['options']),
                    ];
    
                    // limit
                    $index++;
                    $count++;
                    if ($limit > 0 && $count === $limit){
                        break;
                    }
                }
            }
        }
        return $result;
    }

}