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
 * DependencyModel
 */
class DependencyModel extends \Kristuff\Miniweb\Mvc\Model
{
    
    /**
     * Get installed dependencies (check the composer.lock file)
     * 
     * Usage:
     *      $packages = DependencyModel::getDependencies();  
     *      echo $packages[0]->getName();
     *      echo $packages[0]->getVersion();
     *      echo $packages[0]->getNamespace();
     * 
     * @access public
     * @static
     * @return array
     */
    public static function getDependencies(): array
    {
        // index.php is in public folder, composer.lock is located in parent folder
        $rootPath = dirname(get_included_files()[0], 2);
        $composerInfo = new \ComposerLockParser\ComposerInfo($rootPath . '/composer.lock');
        $packages = $composerInfo->getPackages();
        
        return $packages->getArrayCopy();
        
    }
}