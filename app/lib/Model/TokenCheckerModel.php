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
 * @version    0.1.1
 * @copyright  2017-2021 Kristuff
 */

namespace Kristuff\Minitoring\Model;

/** 
 * TokenCheckerModel
 */
class TokenCheckerModel extends \Kristuff\Miniweb\Mvc\Model
{
    /**
     * 
     * @access public
     * @static
     * 
     * @return string
     */
    public static function getOrCreateToken()
    {
        $filePath = self::config('DATA_CONFIG_PATH') . 'key.json';
        if (!file_exists($filePath)) {
            $token = \Kristuff\Miniweb\Security\Token::getNewToken(64);
            $data = json_encode(['key' => $token]);
            file_put_contents($filePath, $data, LOCK_EX);
            return $token;
        };

        $json = json_decode(file_get_contents($filePath));
        return $json->key;
    }

    /**
     * 
     * @access public
     * @static
     * @param string    $token
     * 
     * @return bool
     */
    public static function isTokenValid(string $token): bool
    {
        return !empty(self::getOrCreateToken()) && $token === self::getOrCreateToken();
    }
}