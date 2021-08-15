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

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function script(bool $isDebugMode = false): void
{
    wp_enqueue_script(
        kksr('slug'),
        kksr('public_url').'js/kk-star-ratings'
            .($isDebugMode ? '' : '.min').'.js',
        ['jquery'],
        kksr('version'),
        true
    );

    wp_localize_script(
        kksr('slug'),
        str_replace('-', '_', kksr('slug')),
        [
            'action' => kksr('slug'),
            'endpoint' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce(kksr('wp.actions.wp_ajax_'.kksr('slug'))),
        ]
    );
}