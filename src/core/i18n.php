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

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function i18n($mofile, $domain)
{
    if ($domain !== kksr('domain') || strpos($mofile, WP_LANG_DIR.'/plugins/') !== false) {
        return $mofile;
    }

    $locale = apply_filters('plugin_locale', determine_locale(), $domain);

    return kksr('path').'languages/'.$domain.'-'.$locale.'.mo';
}
