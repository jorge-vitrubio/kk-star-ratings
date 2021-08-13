<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\functions;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function action(string $tag, ...$args): void
{
    $tag = strpos($tag, '/') === 0
        ? substr($tag, 1)
        : ('Bhittani\StarRating\actions\\'.str_replace('/', '\\', $tag));

    do_action($tag, ...$args);
}
