<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\wp\shortcodes;

use function Bhittani\StarRating\functions\filter;
use function Bhittani\StarRating\functions\response;
use Exception;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

/** @param string|array $attrs */
function kk_star_ratings($attrs, string $contents, string $tag): string
{
    $defaults = array_fill_keys([
        'align', 'best', 'count', 'gap', 'greet', 'id',
        'legend', 'readonly', 'score', 'size', 'slug', 'valign',
    ], '') + [
        'explicit' => true,
    ];

    $attrs = (array) $attrs;

    foreach ($attrs as $key => &$value) {
        if (is_numeric($key)) {
            $attrs[$value] = true;
            unset($attrs[$key]);
        }
        if ($value === 'false') {
            $value = false;
        }
        if ($value === 'true') {
            $value = true;
        }
        if ($value === 'null') {
            $value = null;
        }
    }

    $payload = shortcode_atts($defaults, $attrs + ['legend' => $contents], $tag);

    if (! $payload['id']) {
        $payload['id'] = (int) get_the_ID();
    }

    if (! $payload['slug']) {
        $payload['slug'] = 'default';
    }

    $payload['explicit'] = (bool) $payload['explicit'];

    if (! filter('okay', null, $payload['id'], $payload['slug'], $payload)) {
        return '';
    }

    if ($payload['readonly'] === '') {
        try {
            if (filter('validate', null, $payload['id'], $payload['slug'], $payload) === false) {
                throw new Exception;
            }
        } catch (Exception $e) {
            $payload['readonly'] = true;
        }
    }

    return response(array_filter($payload, function ($value) {
        return $value !== '';
    }));
}