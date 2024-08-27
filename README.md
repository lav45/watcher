# File Watcher

Watcher listens and calls event handlers that happen to your files.

## Usage example

```php
use Lav45\Watcher\Event;
use Lav45\Watcher\Listener;
use Lav45\Watcher\Watcher;

$watcher = (new Watcher(new Listener()))
    ->on(IN_CREATE | IN_MOVED_TO, static function(Event $event) {
        echo 'Create ' . $event->path . "\n";
    })
    ->on(IN_DELETE | IN_MOVED_FROM, static function(Event $event) {
        echo 'Delete ' . $event->path . "\n";
    })
    ->on(IN_CLOSE_WRITE, static function(Event $event) {
        echo 'Update ' . $event->path . "\n";
    })
    ->withFilter(fn(Event $event): bool => \str_ends_with($event->path, '.json'))
    ->watchDirs([__DIR__]);

while (true) {
    $watcher->read();
    sleep(1);
}
```

## Testing

```shell
docker run --rm -it -v $(pwd):/app composer install --ignore-platform-req=ext-inotify
docker run --rm -it -v $(pwd):/app composer test
```