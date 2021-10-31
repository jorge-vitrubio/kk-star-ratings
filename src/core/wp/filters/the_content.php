<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\core\wp\filters;

use function Bhittani\StarRating\core\functions\option;
use function Bhittani\StarRating\functions\to_shortcode;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function the_content(string $content): string
{
    foreach ([
        kksr('slug'),
        // Legacy...
        'kkratings', // < v3
        'kkstarratings', // v3, v4
    ] as $tag) {
        if (has_shortcode($content, $tag)) {
            return $content;
        }
    }

    $align = 'left';
    $reference = 'auto';
    $valign = 'top';

    $position = option('position');

    if (strpos($position, 'top-') === 0) {
        $align = substr($position, 4);
        $valign = 'top';
    }

    if (strpos($position, 'bottom-') === 0) {
        $align = substr($position, 7);
        $valign = 'bottom';
    }

    $starRatings = to_shortcode(kksr('slug'), compact('align', 'reference', 'valign'));

    if ($valign == 'top') {
        return $starRatings.$content;
    }

    return $content.$starRatings;
}
