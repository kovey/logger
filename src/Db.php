<?php
/**
 *
 * @description db logger
 *
 * @package     Logger
 *
 * @time        2020-01-18 17:56:17
 *
 * @author      kovey
 */
namespace Kovey\Logger;

class Db
{
    /**
     * @description log dir
     *
     * @var string
     */
    private static string $logDir;

    /**
     * @description set log dir
     *
     * @param string $logDir
     */
    public static function setLogDir(string $logDir) : void
    {
        self::$logDir = $logDir;
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
    }

    /**
     * @description write logger
     *
     * @param string $sql
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
    public static function write(string $sql, mixed $result, float $spentTime, string $traceId = '', string $spanId = '') : void
    {
        go (function (string $sql, mixed $result, float $spentTime, string $traceId, string $spanId) {
            $spentTime = round($spentTime * 1000, 2) . 'ms';
            $content = array(
                'time' => date('Y-m-d H:i:s'),
                'sql' => $sql,
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
        }, $sql, $result, $spentTime, $traceId, $spanId);
    }
}
