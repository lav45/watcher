<?php declare(strict_types=1);

namespace Lav45\Watcher;

use Closure;

final class Watcher
{
    private array $attachDirs = [];

    private array $eventHandlers = [];

    private int $mask = IN_CREATE | IN_DELETE | IN_MOVED_TO | IN_MOVED_FROM;

    private Closure|null $filter = null;

    public function __construct(private readonly ListenerInterface $listener) {}

    public function on(int $mask, Closure $handler): self
    {
        $new = clone $this;
        $new->mask |= $mask;
        $new->eventHandlers[] = [$mask, $handler];
        return $new;
    }

    /**
     * Example:
     * $this->withFilter(static fn(Event $event): bool => str_ends_with($event->name, '.json'))
     */
    public function withFilter(Closure $filter): self
    {
        $new = clone $this;
        $new->filter = $filter;
        return $new;
    }

    public function watchDirs(array|string $target): self
    {
        $new = clone $this;
        foreach ((array)$target as $path) {
            $new->attachDir($path);
        }
        return $new;
    }

    public function read(array $params = [], \Closure $throwException = null): void
    {
        foreach ($this->listener->read() as $item) {
            $event = new Event(
                wd: $item['wd'],
                mask: $item['mask'],
                cookie: $item['cookie'],
                name: $item['name'],
                path: $this->getPath($item),
            );

            if ($this->filtered($event) === false) {
                continue;
            }

            foreach ($this->getEventHandlers($event->mask) as $callback) {
                try {
                    $callback($event, ...$params);
                } catch (\Throwable $exception) {
                    if ($throwException !== null) {
                        $throwException($exception);
                    }
                }
            }
        }
    }

    private function filtered(Event $event): bool
    {
        if ($this->filter === null) {
            return true;
        }
        return (bool)\call_user_func($this->filter, $event);
    }

    private function getPath(array $event): string
    {
        $dir = \array_flip($this->attachDirs)[$event['wd']];
        return $dir . '/' . $event['name'];
    }

    /**
     * @param int $mask
     * @return Closure[]
     */
    private function getEventHandlers(int $mask): iterable
    {
        if ((IN_CREATE | IN_MOVED_TO) & $mask) {
            yield fn(Event $event) => $this->attachDir($event->path);
        }
        if ((IN_DELETE | IN_MOVED_FROM) & $mask) {
            yield fn(Event $event) => $this->detachDir($event->path);
        }

        foreach ($this->eventHandlers as [$on, $handler]) {
            if ($on & $mask) {
                yield $handler;
            }
        }
    }

    private function attachDir(string $path): void
    {
        if (isset($this->attachDirs[$path]) === false && \is_dir($path)) {
            $this->attachDirs[$path] = $this->listener->addWatch($path, $this->mask);
        }
    }

    private function detachDir(string $path): void
    {
        unset($this->attachDirs[$path]);
    }

    public function __destruct()
    {
        $this->attachDirs = [];
        $this->eventHandlers = [];
        $this->mask = 0;
    }
}
