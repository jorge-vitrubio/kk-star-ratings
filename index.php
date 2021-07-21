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

if (!defined('ABSPATH')) {
    http_response_code(404);
    exit();
}

define('KK_STAR_RATINGS', __FILE__);

if (file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    require_once $composer;
}

if (! function_exists('Bhittani\StarRating\functions\dot')) {
    require __DIR__.'/src/functions/dot.php';
}

function kk_star_ratings($keyOrItems = null, $default = null)
{
    static $config;

    if (! $config) {
        $config = ['file' => KK_STAR_RATINGS];

        return kk_star_ratings($keyOrItems, $default);
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

require_once __DIR__.'/src/index.php';
