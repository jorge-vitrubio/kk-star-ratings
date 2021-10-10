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

function v4_v5(): void
{
    // Upgrade options

    $varRegex = '/\[([a-zA-Z0-9_-]+?)\]/';
    $varReplacement = '{$1}';

    option(array_filter([
        'greet' => preg_replace($varRegex, $varReplacement, get_option('kksr_greet')),
        'sd' => preg_replace($varRegex, $varReplacement, get_option('kksr_sd')),
        // This was used in v2 but not afterwards, hence, force to default.
        'legend' => kksr('core.options.legend'),
    ]));

    // Upgrade posts

    global $wpdb;

    $rows = $wpdb->get_results("
        SELECT
            posts.ID
        ,   postmeta_ratings.meta_value as ratings
        ,   postmeta_casts.meta_value as casts
        FROM {$wpdb->posts} posts
        JOIN {$wpdb->postmeta} postmeta_ratings ON posts.ID = postmeta_ratings.post_id
        JOIN {$wpdb->postmeta} postmeta_casts ON posts.ID = postmeta_casts.post_id
        WHERE
            postmeta_ratings.meta_key = '_kksr_ratings'
        AND postmeta_casts.meta_key = '_kksr_casts'
    ");

    foreach ($rows as $row) {
        post_meta($row->ID, [
            'count_default' => $count = (int) $row->casts,
            'ratings_default' => $ratings = (float) $row->ratings,
            'avg_default' => $count ? ($ratings / $count) : 0,
            'status_default' => get_post_meta($row->ID, '_kksr_status', true),
        ]);

        foreach (get_post_meta($row->ID, '_kksr_ref', false) as $fingerprint) {
            post_meta($row->ID, ['fingerprint_default[]' => $fingerprint]);
        }
    }
}
