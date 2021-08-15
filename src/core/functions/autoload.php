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

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

/** @return bool|array */
function autoload(string $namespace, string $path = null, array $excludes = [], int $depth = -1)
{
    if (is_null($path)) {
        return autoload_function($namespace);
    }

    $path = rtrim($path, '\/');
    $cutoffLength = strlen($path) + 1;
    $namespace = rtrim($namespace, '\\');

    $recursiveIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    $recursiveIterator->setMaxDepth($depth);
    $iterator = new RegexIterator($recursiveIterator, '/\.php$/');

    // $autoload = function (string $fn, string $fqcn = null) use (&$autoload) {
    //     $fqcn = $fqcn ?: $fn;

    //     $parts = explode('\\', $fn, 2);
    //     $head = array_shift($parts);
    //     $tail = array_shift($parts);

    //     if (! $tail) {
    //         return [$head => $fqcn];
    //     }

    //     return [$head => $autoload($tail, $fqcn)];
    // };

    // $autoloads = [];

    // foreach (iterator_to_array($iterator) as $splFileInfo) {
    //     $filepath = (string) $splFileInfo;
    //     $filename = substr($filepath, $cutoffLength);

    //     if (in_array($filename, $excludes)) {
    //         continue;
    //     }

    // $name = substr($filename, 0, -4);
    // $name = preg_replace('/[\/\\\]/', '/', $name);
    // $fn = preg_replace('/\//', '\\', $name);
    // $fn = preg_replace('/([^a-zA-Z0-9\\\]+?)/', '_', $fn);
    // $fqcn = $namespace.'\\'.$fn;

    //     if (! function_exists($fqcn)) {
    //         require_once $filepath;
    //     }

    //     $autoloads = array_replace_recursive($autoloads, $autoload($fn, $fqcn));
    // }

    // return $autoloads;

    $autoloads = [];

    foreach (iterator_to_array($iterator) as $splFileInfo) {
        $filepath = (string) $splFileInfo;
        $filename = substr($filepath, $cutoffLength);

        if (in_array($filename, $excludes)) {
            continue;
        }

        $name = substr($filename, 0, -4);
        $name = preg_replace('/[\/\\\]/', '/', $name);
        $fn = preg_replace('/\//', '\\', $name);
        $fn = preg_replace('/([^a-zA-Z0-9\\\]+?)/', '_', $fn);
        $fqcn = $namespace.'\\'.$fn;

        if (! function_exists($fqcn)) {
            require_once $filepath;

            if (! function_exists($fqcn)) {
                continue;
            }
        }

        $autoloads = [$name => $fqcn] + $autoloads;
    }

    return $autoloads;
}
