<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\core\actions;

use function Bhittani\StarRating\core\functions\add_migration;
use function Bhittani\StarRating\core\functions\upgrade_options;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function upgrade0(string $version, string $previous): void
{
    if (version_compare($previous, '5.0.2', '<')) {
        upgrade_options();
    }

    $pendingMigrations = [];

    foreach (kksr('core.migrations') as $tag => $fn) {
        $tagParts = explode('/', $tag, 2);
        $taggedVersion = substr($tagParts[0], 1);

        if (version_compare($taggedVersion, $previous, '>')
            && version_compare($taggedVersion, $version, '<=')
        ) {
            $pendingMigrations[] = [
                'version' => $taggedVersion,
            ] + compact('tag', 'fn');
        }
    }

    // Will already be sorted, but lets be damn sure!
    usort($pendingMigrations, function ($a, $b) {
        return version_compare($a['version'], $b['version']);
    });

    foreach ($pendingMigrations as $pendingMigration) {
        [$_, $payloadFn] = $pendingMigration['fn']();
        add_migration($pendingMigration['tag'], $payloadFn($pendingMigration['version']));
    }
}
