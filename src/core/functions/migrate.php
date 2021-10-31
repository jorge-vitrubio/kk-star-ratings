<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\core\functions;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

/**
 * @return int
 *             0  -> Could not process any migration.
 *             1  -> The migration was processed and completed.
 *             2  -> The migration was processed but still pending.
 *             4  -> There are no migrations available.
 *             8  -> The migration is already being processed.
 *             16 -> The migration is not current.
 */
function migrate(): int
{
    if (migrations()->isEmpty()) {
        return 4;
    }

    foreach (kksr('core.migrations') as $tag => $options) {
        [$fn] = $options();
        $code = migrations()->migrate($tag, $fn);

        if (in_array($code, [1, 2, 4, 8])) {
            return $code;
        }
    }

    return isset($code) ? $code : 0;
}
