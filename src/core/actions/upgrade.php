<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\core\actions;

use function Bhittani\StarRating\core\functions\v2_v4;
use function Bhittani\StarRating\core\functions\v4_v5;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function upgrade(string $version, string $previous): void
{
    if (version_compare($previous, '5.0.0-alpha', '<')) {
        if (version_compare($previous, '4.0.0', '>=')) {
            v4_v5();
        } elseif (version_compare($previous, '3.0.1', '>=')) {
            v4_v5();
        } elseif (version_compare($previous, '2.0.0', '>=')) {
            v2_v4();
            v4_v5();
        }
    }
}
