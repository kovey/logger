<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2020-10-21 17:05:50
 *
 */
Swoole\Coroutine::set(array('hook_flags' => SWOOLE_HOOK_ALL));

Swoole\Coroutine\Run(function () {
    try {
        global $argc, $argv;
        require __DIR__ . '/../vendor/bin/phpunit';
    } catch (Exception $e) {
        if ($e->getMessage() === 'swoole exit') {
            return;
        }

        throw $e;
    }
});
