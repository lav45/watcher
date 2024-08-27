<?php declare(strict_types=1);

namespace Lav45\Watcher\Test;

use Lav45\Watcher\Event;
use Lav45\Watcher\ListenerInterface;
use Lav45\Watcher\Watcher;
use PHPUnit\Framework\TestCase;

final class WatcherTest extends TestCase
{
    public function testMemoryLiquid(): void
    {
        $initialMemory = \memory_get_usage(true);

        for ($i = 0; $i < 1000; $i++) {

            $watcher = (new Watcher(new Listener()))
                ->on(IN_MOVE, static fn () => true)
                ->on(IN_DELETE, static fn () => true)
                ->on(IN_MOVED_TO, static fn () => true)
                ->on(IN_MOVED_FROM, static fn () => true)
                ->on(IN_CREATE, static fn () => true)
                ->watchDirs([\dirname(__DIR__, 2)]);

            $watcher->read();

            unset($watcher);
        }

        $finalMemory = \memory_get_usage(true);

        $this->assertLessThanOrEqual($initialMemory, $finalMemory);
    }

    public function testOn(): void
    {
        $status = null;

        $watcher = (new Watcher(new Listener()))
            ->watchDirs(__DIR__)
            ->on(IN_CREATE, function () use (&$status) {
                $status = true;
            });

        $watcher->read();

        $this->assertTrue($status);
    }

    public function testWithFilter(): void
    {
        $status = null;

        $watcher = (new Watcher(new Listener()))
            ->withFilter(static fn(Event $event) => \str_ends_with($event->name, '.json'))
            ->watchDirs(__DIR__)
            ->on(IN_CREATE, function () use (&$status) {
                $status = true;
            });

        $watcher->read();

        $this->assertNull($status);
    }
}

class Listener implements ListenerInterface
{
    public function addWatch(string $dir, int $mask): int
    {
        return 1;
    }

    public function read(): \Generator
    {
        yield [
            'wd' => 1,
            'mask' => IN_CREATE,
            'cookie' => 0,
            'name' => 'file.txt',
        ];
        yield [
            'wd' => 1,
            'mask' => IN_MODIFY,
            'cookie' => 0,
            'name' => 'file.txt',
        ];
        yield [
            'wd' => 1,
            'mask' => IN_DELETE,
            'cookie' => 0,
            'name' => 'file.txt',
        ];
    }
}
