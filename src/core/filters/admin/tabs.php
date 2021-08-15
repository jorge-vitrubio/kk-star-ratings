<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\filters\admin;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function tabs(array $tabs): array
{
    return array_merge([
        __('General', 'kk-star-ratings'),
        __('Appearance', 'kk-star-ratings'),
        __('Rich Snippets', 'kk-star-ratings'),
        // [
        //     'tab' => __('Addons', 'kk-star-ratings'),
        //     'is_addon' => true,
        // ],
    ], $tabs);
}