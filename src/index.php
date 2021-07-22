<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

kksr(require __DIR__.'/config.php');

require_once __DIR__.'/hooks.php';

register_activation_hook(kksr('file'), kksr('core.activate'));
register_deactivation_hook(kksr('file'), kksr('core.deactivate'));

add_filter('load_textdomain_mofile', kksr('core.i18n'), 10, 2);

add_action('wp_head', kksr('core.head'));

add_action('wp_enqueue_scripts', kksr('core.assets'));

add_action('wp_ajax_'.kksr('slug'), kksr('core.controller'));
add_action('wp_ajax_nopriv_'.kksr('slug'), kksr('core.controller'));

add_shortcode('kkratings', kksr('core.shortcode'));
add_shortcode('kkstarratings', kksr('core.shortcode'));
add_shortcode('kk-star-ratings', kksr('core.shortcode'));

add_action('the_content', kksr('core.content'));

// admin

add_action('admin_menu', kksr('core.admin'));

// Metabox

add_action('add_meta_boxes', kksr('core.metabox'), 10, 2);
add_action('save_post', kksr('core.save_metabox'));

// Initialize
add_action('plugins_loaded', kksr('core.ready'));
