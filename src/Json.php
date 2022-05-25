<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2022-05-23 12:09:28
 *
 */
namespace Kovey\Logger;

class Json
{
    private static string $logDir = '';

    private static string $eventDir = '';

    private static string $appId = '';

    public static function setAppId(string $appId) : void
    {
        self::$appId = $appId;
    }

    public static function getAppId() : string
    {
        return self::$appId;
    }

    public static function setLogDir(string $logDir) : void
    {
        self::$logDir = $logDir;
        if (!is_dir(self::$logDir)) {
            mkdir(self::$logDir, 0777, true);
        }
    }

    public static function setEventDir(string $eventDir) : void
    {
        self::$eventDir = $eventDir;
        if (is_dir(self::$eventDir)) {
            return;
        }

        mkdir(self::$eventDir, 0777, true);
    }

    public static function write(Array $logs) : void
    {
        if (empty(self::$logDir) || !is_dir(self::$logDir)) {
            return;
        }

        go (
            fn(string $logs) => file_put_contents(self::$logDir . '/' . date('Y-m-d') . '.log', $logs . PHP_EOL, FILE_APPEND), 
            json_encode($logs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );
    }

    public static function writeEvent(Array $events) : void
    {
        if (empty($events)) {
            return;
        }

        if (empty(self::$eventDir) || !is_dir(self::$eventDir)) {
            return;
        }

        $logs = '';
        foreach ($events as $event) {
            $logs .= json_encode($event->toArray(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;
        }

        go (fn (string $logs) => file_put_contents(self::$eventDir . '/' . date('Y-m-d') . '.log', $logs, FILE_APPEND), $logs);
    }
}
