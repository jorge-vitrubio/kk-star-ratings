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
 * Version:         5.0.alpha
 * License:         GPLv2 or later
 */

if (! defined('ABSPATH')) {
    http_response_code(404);
    exit();
}

define('KK_STAR_RATINGS', __FILE__);

foreach ([
    'freemius.php',
    'vendor/autoload.php',
] as $filename) {
    if (file_exists($filepath = __DIR__.'/'.ltrim($filename, '\/'))) {
        require_once $filepath;
    }
}

require_once __DIR__.'/src/index.php';
require_once __DIR__.'/src/core/index.php';
/* @fs */
require_once __DIR__.'/src/custom-stars/index.php';
/* @endfs */
