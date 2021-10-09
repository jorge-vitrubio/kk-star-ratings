<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

kksr(['core' => require __DIR__.'/config.php']);

require_once __DIR__.'/hooks.php';
require_once __DIR__.'/hydrate.php';

register_activation_hook(KK_STAR_RATINGS, kksr('core.wp.functions.activate'));
register_deactivation_hook(KK_STAR_RATINGS, kksr('core.wp.functions.deactivate'));
