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
    private static string $logDir;

    public static function setLogDir(string $logDir) : void
    {
        self::$logDir = $logDir;
        if (!is_dir(self::$logDir)) {
            mkdir(self::$logDir, 0777, true);
        }
    }

    public static function write(Array $logs) : void
    {
        if (!is_dir(self::$logDir)) {
            return;
        }

        go (function (Array $logs) : void {
            file_put_contents(self::$logDir . '/' . date('Y-m-d') . '.log', json_encode($logs) . PHP_EOL, FILE_APPEND);
        }, $logs);
    }
}
