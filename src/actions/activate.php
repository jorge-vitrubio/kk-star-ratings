<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\actions;

use function Bhittani\StarRating\functions\option;
use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function activate(string $version, ?string $previous): void
{
    $options = array_map(function ($key) {
        return option($key);
    }, array_keys(kksr('options')));

    option($options);
}
