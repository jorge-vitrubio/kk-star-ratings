<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

foreach ([
    'vendor/autoload.php',
    'src/core/functions/autoload.php',
    'src/core/functions/autoload_function.php',
    'freemius.php',
] as $filename) {
    if (file_exists($filepath = dirname(KK_STAR_RATINGS).'/'.ltrim($filename, '\/'))) {
        require_once $filepath;
    }
}

require_once __DIR__.'/kksr.php';

kksr(require __DIR__.'/config.php');

foreach ([
    'hooks.php',
    'hydrate.php',
    'kk_star_ratings.php',
] as $filename) {
    $filepath = __DIR__.'/'.ltrim($filename, '\/');
    require_once $filepath;
}
