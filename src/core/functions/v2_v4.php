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

function v2_v4(): void
{
    // Upgrade options

    option([
        'strategies' => array_filter([
            'guests',
            get_option('kksr_unique') ? 'unique' : null,
            get_option('kksr_disable_in_archives', true) ? null : 'archives',
        ]),
        'exclude_locations' => array_filter([
            get_option('kksr_show_in_home', true) ? null : 'home',
            get_option('kksr_show_in_posts', true) ? null : 'post',
            get_option('kksr_show_in_pages', true) ? null : 'page',
            get_option('kksr_show_in_archives', true) ? null : 'archives',
        ]),
        'exclude_categories' => is_array($exludeCategories = get_option('kksr_exclude_categories', []))
            ? $exludeCategories : array_map('trim', explode(',', $exludeCategories)),
    ]);

    // Upgrade posts

    global $wpdb;

    // Truncate IP addresses.
    $wpdb->delete($wpdb->postmeta, ['meta_key' => '_kksr_ips']);

    // Normalize post ratings.

    $rows = $wpdb->get_results("
        SELECT posts.ID, postmeta_avg.meta_value as avg, postmeta_casts.meta_value as casts
        FROM {$wpdb->posts} posts
        JOIN {$wpdb->postmeta} postmeta_avg ON posts.ID = postmeta_avg.post_id
        JOIN {$wpdb->postmeta} postmeta_casts ON posts.ID = postmeta_casts.post_id
        WHERE postmeta_avg.meta_key = '_kksr_avg' AND postmeta_casts.meta_key = '_kksr_casts'
    ");

    $stars = max((int) get_option('kksr_stars', 5), 1);

    foreach ($rows as $row) {
        $casts = max((int) $row->casts, 0);
        $score = min(max($row->avg, 0), $stars);
        $ratings = $score * $casts / $stars * 5;

        post_meta($row->ID, compact('casts', 'ratings'));
    }
}
