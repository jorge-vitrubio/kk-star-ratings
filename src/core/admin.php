<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\core;

use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function admin(): void
{
    add_menu_page(
        kksr('name'),
        kksr('name'),
        'manage_options',
        kksr('slug'),
        function () {
            do_action(kksr('actions.admin/index'));
        },
        'dashicons-star-filled'
    );
}