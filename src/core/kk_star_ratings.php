<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use function Bhittani\StarRating\functions\autoload;
use function Bhittani\StarRating\functions\to_shortcode;

autoload('Bhittani\StarRating\functions\to_shortcode');

// foreach ([
//     'Bhittani\StarRating\functions\to_shortcode' => 'src/core/functions/to_shortcode.php',
// ] as $fn => $filepath) {
//     if (! function_exists($fn)) {
//         require_once dirname(KK_STAR_RATINGS).'/'.ltrim($filepath, '\/');
//     }
// }

/** @param int|string|array|object|WP_POST|null $idOrPostOrPayload */
function kk_star_ratings($idOrPostOrPayload = null): string
{
    $payload = [];

    if (is_array($idOrPostOrPayload)) {
        $payload = $idOrPostOrPayload;
    }

    if (is_object($idOrPostOrPayload)) {
        $payload['id'] = $idOrPostOrPayload->ID;
    }

    if ($idOrPostOrPayload) {
        $payload['id'] = $idOrPostOrPayload;
    }

    return do_shortcode(to_shortcode('kk-star-ratings', $payload));
}
