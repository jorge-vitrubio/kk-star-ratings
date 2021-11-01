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

use function Bhittani\StarRating\core\functions\migrations;
use function Bhittani\StarRating\core\functions\upgrade_options;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function upgrade(string $version, string $previous): void
{
    if (version_compare($previous, '5.0.2', '<')) {
        upgrade_options();
    }

    if (version_compare($previous, '5.1.4', '<')) {
        $migrations = migrations();

        if (! $migrations->isEmpty()
            && ($migration = $migrations->bottom())
            && $migration['tag'] == 'v5.1.0/posts'
        ) {
            $migration['payload']['paged'] = 1;
            $migration['payload']['posts_per_page'] = 5;
            $migrations->replace($migration)->persist();
        }
    }

    $migrations = migrations();

    $pendingMigrations = [];

    foreach (kksr('core.migrations') as $tag => $options) {
        $mtag = (string) substr(explode('/', $tag, 2)[0], 1);

        if (version_compare($mtag, $previous, '>')
            && version_compare($mtag, $version, '<=')
            && ($migrations->isEmpty()
                || (
                    ($ttag = (string) substr(explode('/', $migrations->top()['tag'], 2)[0], 1))
                        && version_compare($mtag, $ttag, '>')
                )
            )
        ) {
            $pendingMigrations[] = compact('tag', 'options') + ['version' => $mtag];
        }
    }

    // Will already be sorted, but lets be damn sure!
    usort($pendingMigrations, function ($a, $b) {
        return version_compare($a['version'], $b['version']);
    });

    foreach ($pendingMigrations as $pendingMigration) {
        [$_, $payloadFn] = $pendingMigration['options']();

        $migrations->create(
            $pendingMigration['tag'],
            $payloadFn($version, $previous)
        );
    }

    $migrations->persist();
}
