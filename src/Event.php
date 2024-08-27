<?php declare(strict_types=1);

namespace Lav45\Watcher;

final readonly class Event
{
    public function __construct(
        public int    $wd,
        public int    $mask,
        public int    $cookie,
        public string $name,
        public string $path,
    ) {}
}
