<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\core\wp\actions;

use function Bhittani\StarRating\core\functions\action;
use function Bhittani\StarRating\core\functions\calculate;
use function Bhittani\StarRating\core\functions\option;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function wp_head(): void
{
    if (option('enable') && option('grs') && is_singular()) {
        $best = option('stars');
        $id = get_post_field('ID');
        $title = esc_html(get_post_field('post_title'));
        [$count, $score] = calculate($id, 'default', $best);

        if ($count && $score) {
            ob_start();
            action('sd', compact('id', 'best', 'title', 'count', 'score'));
            echo ob_get_clean();
        }
    }
}
