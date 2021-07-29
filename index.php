<?php

/**
 * Plugin Name:     kk Star Ratings
 * Plugin Slug:     kk-star-ratings
 * Plugin Nick:     kksr
 * Plugin URI:      https://github.com/kamalkhan/kk-star-ratings
 * Description:     Allow blog visitors to involve and interact more effectively with your website by rating posts.
 * Author:          Kamal Khan
 * Author URI:      http://bhittani.com
 * Text Domain:     kk-star-ratings
 * Domain Path:     /languages
 * Version:         5.0
 * License:         GPLv2 or later
 */

use function Bhittani\StarRating\functions\dot;
use function Bhittani\StarRating\functions\to_shortcode;

if (! defined('ABSPATH')) {
    http_response_code(404);
    exit();
}

define('KK_STAR_RATINGS', __FILE__);

foreach ([
    'vendor/autoload.php',
    'freemius.php',
] as $filepath) {
    if (file_exists($filepath)) {
        require_once __DIR__.'/'.ltrim($filepath, '\/');
    }
}

foreach ([
    'Bhittani\StarRating\functions\dot' => 'src/functions/dot.php',
] as $fn => $filepath) {
    if (! function_exists($fn)) {
        require_once __DIR__.'/'.ltrim($filepath, '\/');
    }
}

/** @param string|array|null $keyOrItems */
function kksr($keyOrItems = null, $default = null)
{
    static $config;

    if (! $config) {
        $config = ['file' => KK_STAR_RATINGS];

        return kksr($keyOrItems, $default);
    }

    if (is_array($keyOrItems)) {
        $config = array_merge($config, $keyOrItems);

        return $config;
    }

    if (! is_null($keyOrItems)) {
        return dot($config, $keyOrItems, $default);
    }

    return $config;
}

/** @param int|string|array|object|WP_POST|null $idOrPostOrPayload */
function kk_star_ratings($idOrPostOrPayload = null): string
{
    $payload = [];

    if (is_array($idOrPostOrPayload)) {
        $payload = $idOrPostOrPayload;
    }

    if (is_object($idOrPostOrPayload)) {
        $payload['id'] = $idOrPostOrPayload->ID;
    }

    if ($idOrPostOrPayload) {
        $payload['id'] = $idOrPostOrPayload;
    }

    return do_shortcode(to_shortcode('kk-star-ratings', $payload));
}

require_once __DIR__.'/src/index.php';
