<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\core;

use function Bhittani\StarRating\functions\action;
use function Bhittani\StarRating\functions\option;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function activate(): void
{
    $version = kksr('version');
    $previous = option('ver');

    if (! $previous) {
        action('install', $version);
    } elseif (version_compare($previous, '5.0.dev', '<')) {
        action('upgrade', $version, $previous);
    }

    action('activate', $version, $previous);

    option(['ver' => $version]);
}
