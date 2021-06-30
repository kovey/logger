<?php
/**
 *
 * @description redis log
 *
 * @package     Logger
 *
 * @time        2020-01-18 17:56:17
 *
 * @author      kovey
 */
namespace Kovey\Logger;

class Redis
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
        self::$logDir = $logDir . '/redis';
        if (!is_dir(self::$logDir)) {
            mkdir(self::$logDir, 0777, true);
        }
    }

    /**
     * @description write logger content
     *
     * @param string $command
     *
     * @param Array $params
     *
     * @param mixed $result
     *
     * @param float $spentTime
     *
     * @param string $traceId
     *
     * @param string $spanId
     *
     * @return void
     */
    public static function write(string $command, Array $params, mixed $result, float $spentTime, string $traceId = '', string $spanId = '') : void
    {
        go (function (string $command, Array $params, mixed $result, float $spentTime, $traceId, $spanId) {
            $spentTime = round($spentTime * 1000, 2) . 'ms';
            $content = array(
                'time' => date('Y-m-d H:i:s'),
                'command' => $command,
                'params' => $params,
                'delay'  => $spentTime,
                'traceId' => $traceId,
                'spanId' => $spanId,
                'result' => $result
            );
            file_put_contents(
                self::$logDir . '/' . date('Y-m-d') . '.log',
                json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL,
                FILE_APPEND
            );
        }, $command, $params, $result, $spentTime, $traceId, $spanId);
    }
}
