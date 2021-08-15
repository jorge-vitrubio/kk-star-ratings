<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\functions;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function v4_v5(): void
{
    // Upgrade options

    $varRegex = '/\[([\s\S]*?)\]/';
    $varReplacement = '{$1}';

    option([
        'legend' => preg_replace($varRegex, $varReplacement, get_option('kksr_legend')),
        'sd' => preg_replace($varRegex, $varReplacement, get_option('kksr_sd')),
    ]);

    // Upgrade posts

    global $wpdb;

    $rows = $wpdb->get_results("
        SELECT posts.ID FROM {$wpdb->posts} posts
        WHERE posts.post_type NOT IN ('attachment','revision','nav_menu_item')
    ");

    foreach ($rows as $row) {
        post_meta($row->ID, [
            'count_default' => get_post_meta($row->ID, '_kksr_casts', true),
            'ratings_default' => get_post_meta($row->ID, '_kksr_ratings', true),
            'status_default' => get_post_meta($row->ID, '_kksr_status', true),
        ]);

        foreach (get_post_meta($row->ID, '_kksr_ref', false) as $fingerprint) {
            post_meta($row->ID, ['fingerprint_default[]' => $fingerprint]);
        }
    }
}
