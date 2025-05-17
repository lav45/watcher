<?php declare(strict_types=1);

namespace Lav45\Watcher;

interface WatcherInterface
{
    public function on(int $mask, \Closure $handler): self;

    /**
     * Example:
     * $this->withFilter(static fn(\Lav45\Watcher\Event $event): bool => str_ends_with($event->name, '.json'))
     */
    public function withFilter(\Closure $filter): self;

    public function watchDirs(array|string $target): self;

    public function read(array $params = [], \Closure|null $throwException = null): void;
}
