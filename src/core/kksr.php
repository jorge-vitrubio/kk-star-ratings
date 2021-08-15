<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use function Bhittani\StarRating\core\functions\autoload;
use function Bhittani\StarRating\core\functions\dot;

autoload('Bhittani\StarRating\core\functions\dot');

// foreach ([
//     'Bhittani\StarRating\core\functions\dot' => 'src/core/functions/dot.php',
// ] as $fn => $filepath) {
//     if (! function_exists($fn)) {
//         require_once dirname(KK_STAR_RATINGS).'/'.ltrim($filepath, '\/');
//     }
// }

/** @param string|array|null $keyOrItems */
function kksr($keyOrItems = null, $default = null)
{
    static $config;

    if (! $config) {
        $config = ['file' => KK_STAR_RATINGS];

        return kksr($keyOrItems, $default);
    }

    if (is_array($keyOrItems)) {
        return $config = dot($config, $keyOrItems);
    }

    if (! is_null($keyOrItems)) {
        return dot($config, $keyOrItems, $default);
    }

    return $config;
}
