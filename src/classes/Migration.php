<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\classes;

use function Bhittani\StarRating\functions\autoload_class;

autoload_class(Stack::class);

class Migration extends Stack
{
    /** @var callable */
    protected $cron;

    public function cron(callable $cron): self
    {
        $this->cron = $cron;

        return $this;
    }

    public function isBusy(): bool
    {
        return ! $this->isEmpty()
            && $this->bottom()['status'] == 'working';
    }

    public function isPending(): bool
    {
        return ! ($this->isEmpty() || $this->isBusy());
    }

    public function create(string $tag, $payload): self
    {
        $this->push([
            'payload' => $payload,
            'status' => 'pending',
            'tag' => $tag,
            'times' => 0,
            'timestamp' => time(),
        ]);

        return $this;
    }

    public function replace($migration): self
    {
        $this->shift();
        $this->unshift($migration);

        return $this;
    }

    public function remove(): self
    {
        $this->shift();

        return $this;
    }

    public function scheduleOnce(int $seconds = 5, bool $force = false): self
    {
        // $this->unschedule(true);

        if ($this->cron
            && (! $this->isEmpty() || $force)
            && ! wp_next_scheduled($this->cron)
        ) {
            wp_schedule_single_event(time() + $seconds, $this->cron, [], true);
        }

        return $this;
    }

    public function schedule(bool $force = false): self
    {
        if ($this->cron
            && (! $this->isEmpty() || $force)
            && ! wp_next_scheduled($this->cron)) {
            wp_schedule_event(time(), 'one_minute', $this->cron);
        }

        return $this;
    }

    public function unschedule(bool $force = false): self
    {
        if ($this->cron
            && ($this->isEmpty() || $force)
        ) {
            $timestamp = wp_next_scheduled($this->cron);
            wp_unschedule_event($timestamp, $this->cron);
        }

        return $this;
    }

    /**
     * @return int
     *             1  -> The migration was processed and completed.
     *             2  -> The migration was processed but still pending.
     *             4  -> There are no migrations available.
     *             8  -> The migration is already being processed.
     *             16 -> The migration is not current.
     */
    public function migrate(string $tag, callable $fn): int
    {
        if ($this->isEmpty()) {
            return 4;
        }

        $migration = $this->bottom();

        if ($migration['tag'] !== $tag) {
            return 16;
        }

        if ($migration['status'] == 'working') {
            $seconds = time() - $migration['timestamp'];

            if ($seconds <= 60) {
                return 8;
            }
        }

        $migration['status'] = 'working';
        $migration['timestamp'] = time();

        $this->replace($migration)->persist();

        $value = $fn($migration['payload']);

        if (is_null($value)) {
            $this->remove()->persist();

            return 1;
        }

        $migration['payload'] = $value;
        $migration['status'] = 'pending';
        $migration['timestamp'] = time();
        $migration['times'] = $migration['times'] + 1;

        $this->replace($migration)->persist();

        return 2;
    }
}
