<?php declare(strict_types=1);

namespace Lav45\Watcher;

interface ListenerInterface
{
    public function addWatch(string $dir, int $mask): int;

    public function read(): iterable;
}
