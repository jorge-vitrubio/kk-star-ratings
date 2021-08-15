<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\wp\actions\deactivate_kk_star_ratings;

use function Bhittani\StarRating\functions\action;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function index(): void
{
    action('deactivate', kksr('version'));
}
