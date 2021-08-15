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

use FilesystemIterator;
use RuntimeException;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

/** @throws RuntimeException if the function can not be autoloaded. */
function autoload_function(string $fqcn): bool
{
    static $core;

    if (function_exists($fqcn)) {
        return false;
    }

    $prefix = 'Bhittani\StarRating\\';

    if (strpos($fqcn, $prefix) !== 0) {
        throw new RuntimeException("Failed to autoload function '{$fqcn}`");
    }

    if (is_null($core)) {
        $core = array_filter(array_map(function ($fileInfo) {
            if ($fileInfo->isDir()) {
                return $fileInfo->getFilename();
            }
        }, iterator_to_array(new FilesystemIterator(dirname(KK_STAR_RATINGS).'/src/core'))));
    }

    $name = substr($fqcn, strlen($prefix));
    $parts = explode('\\', $name);

    if (in_array($parts[0], $core)) {
        array_unshift($parts, 'core');
    }

    // kebab-Case
    $parts = array_map(function (string $part) {
        return preg_replace(['/([a-z\d])([A-Z])/', '/([^-_])([A-Z][a-z])/'], '$1-$2', $part);
    }, $parts);

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
