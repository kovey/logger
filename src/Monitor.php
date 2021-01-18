<?php
/**
 *
 * @description monitor logger manager
 *
 * @package     Library\Monitor
 *
 * @time        2020-01-18 17:48:50
 *
 * @author      kovey
 */
namespace Kovey\Logger;

class Monitor
{
    /**
     * @description logger directory
     *
     * @var string
     */
    private static string $logDir;

    /**
     * @description set logger directory
     *
     * @param string $logDir
     *
     * @return void
     */
    public static function setLogDir(string $logDir) : void
    {
        self::$logDir = $logDir . '/monitor';
        if (!is_dir(self::$logDir)) {
            mkdir(self::$logDir, 0777, true);
        }
    }

    /**
     * @description write logger content into file
     *
     * @param Array $content
     *
     * @return void
     */
    public static function write(Array $content) : void
    {
        go (function (Array $content) {
            $content = json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            file_put_contents(
                self::$logDir . '/' . date('Y-m-d') . '.log',
                $content . PHP_EOL,
                FILE_APPEND
            );
        }, $content);
    }
}
