<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use function Bhittani\StarRating\core\functions\action;

if (! defined('ABSPATH')) {
    http_response_code(404);
    exit();
}

define('KK_STAR_RATINGS', __FILE__);

/* @dev */
require_once __DIR__.'/vendor/autoload.php';
/* @enddev */

if (function_exists('kksr_freemius')) {
    kksr_freemius()->set_basename(true, __FILE__);
} else {
    if (! function_exists('kksr_freemius')) {
        require_once __DIR__.'/freemius.php';
    }

    require_once __DIR__.'/src/index.php';
    require_once __DIR__.'/src/core/index.php';

    // Let everyone know that the plugin is loaded.
    action('init', kksr());
}
