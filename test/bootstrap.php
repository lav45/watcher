<?php declare(strict_types=1);

require(__DIR__ . '/../vendor/autoload.php');

/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_ACCESS = 1;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_MODIFY = 2;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_ATTRIB = 4;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_CLOSE_WRITE = 8;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_CLOSE_NOWRITE = 16;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_OPEN = 32;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_MOVED_FROM = 64;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_MOVED_TO = 128;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_CREATE = 256;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_DELETE = 512;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_DELETE_SELF = 1024;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_MOVE_SELF = 2048;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_UNMOUNT = 8192;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_Q_OVERFLOW = 16384;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_IGNORED = 32768;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_CLOSE = 24;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_MOVE = 192;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_ALL_EVENTS = 4095;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_ONLYDIR = 16777216;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_DONT_FOLLOW = 33554432;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_MASK_ADD = 536870912;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_ISDIR = 1073741824;
/**
 * @link https://php.net/manual/en/inotify.constants.php
 */
const IN_ONESHOT = 2147483648;