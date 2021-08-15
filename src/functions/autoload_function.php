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

use RuntimeException;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

/** @throws RuntimeException if the function can not be autoloaded. */
function autoload_function(string $fqcn): bool
{
    if (function_exists($fqcn)) {
        return false;
    }

    $name = $fqcn;
    $prefix = 'Bhittani\StarRating\\';

    if (strpos($fqcn, '\\') !== 0
        && strpos($fqcn, $prefix) !== 0
    ) {
        $fqcn = $prefix.$fqcn;
    }

    if (strpos($fqcn, $prefix) === 0) {
        $name = substr($fqcn, strlen($prefix));
    }

    $fqcn = trim($fqcn, '\\');
    $name = trim($name, '\\');

    // kebab-Case
    $parts = array_map(function (string $part) {
        return preg_replace(['/([a-z\d])([A-Z])/', '/([^-_])([A-Z][a-z])/'], '$1-$2', $part);
    }, explode('\\', $name));

    $filepath = dirname(KK_STAR_RATINGS).'/src/'.implode('/', $parts).'.php';

    if (! is_file($filepath)) {
        throw new RuntimeException("Failed to autoload function '{$fqcn}` because the file `{$filepath}` does not exist");
    }

    require_once $filepath;

    if (! function_exists($fqcn)) {
        throw new RuntimeException("Failed to autoload function '{$fqcn}` because the file `{$filepath}` does not contain the function `${fqcn}`");
    }

    return true;
}
