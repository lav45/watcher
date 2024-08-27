<?php declare(strict_types=1);

namespace Lav45\Watcher;

final class Listener implements ListenerInterface
{
    private mixed $inotify;

    public function __construct(bool $async = false)
    {
        $this->inotify = \inotify_init();
        stream_set_blocking($this->inotify, $async);
    }

    public function read(): iterable
    {
        $events = \inotify_read($this->inotify);
        if ($events !== false) {
            yield from $events;
        }
    }

    public function addWatch(string $dir, int $mask): int
    {
        return \inotify_add_watch($this->inotify, $dir, $mask);
    }

    public function __destruct()
    {
        \fclose($this->inotify);
    }
}
