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

use ReflectionFunction;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function hook(string $type, string $tag, string $fn): bool
{
    if (! function_exists($fn)) {
        return false;
    }

    return ('add_'.$type)($tag, $fn, 9, (new ReflectionFunction($fn))->getNumberOfParameters());
}
