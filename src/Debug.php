<?php
/**
 * @description Debug
 *
 * @package
 *
 * @author kovey
 *
 * @time 2021-07-21 19:39:19
 *
 */
namespace Kovey\Logger;

class Debug
{
    /**
     * @description not print log
     *
     * @var int
     */
    const LOG_LEVEL_NO = 0;

    /**
     * @description print all log
     *
     * @var int
     */
    const LOG_LEVEL_INFO = 1;

    /**
     * @description only print debug ,error warning log
     *
     * @var int
     */
    const LOG_LEVEL_DEBUG = 2;

    /**
     * @description only print error and warning log
     *
     * @var int
     */
    const LOG_LEVEL_WARNING = 3;

    /**
     * @description only print error log
     *
     * @var int
     */
    const LOG_LEVEL_ERROR = 4;

    const LOGGER_FORMAT = '[%s][%s] %s with %s in %s on line %s';

    const DATE_FORMAT = 'Y-m-d H:i:s';

    private static int $level = self::LOG_LEVEL_NO;

    public static function setLevel(int $level) : void
    {
        self::$level = $level;
    }

    public static function info(string $format, mixed ...$params) : void
    {
        if (self::$level != self::LOG_LEVEL_INFO) {
            return;
        }

        self::formatLog('info', $format, $params, debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2));
    }

    public static function debug(string $format, mixed ...$params) : void
    {
        if (self::$level < self::LOG_LEVEL_INFO || self::$level > self::LOG_LEVEL_DEBUG) {
            return;
        }

        self::formatLog('debug', $format, $params, debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2));
    }
    
    public static function warning(string $format, mixed ...$params) : void
    {
        if (self::$level < self::LOG_LEVEL_INFO || self::$level > self::LOG_LEVEL_WARNING) {
            return;
        }

        self::formatLog('warning', $format, $params, debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2));
    }

    public static function error(string $format, mixed ...$params) : void
    {
        if (self::$level < self::LOG_LEVEL_INFO) {
            return;
        }

        self::formatLog('error', $format, $params, debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2));
    }

    private static function formatLog(string $logLevel, string $format, Array $params, Array $trace) : void
    {
        if (!empty($params)) {
            array_walk($params, function (&$row) {
                if (!is_array($row)) {
                    return;
                }

                $row = json_encode($row, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            });
        }

        echo sprintf(
            self::LOGGER_FORMAT . PHP_EOL, $logLevel, date(self::DATE_FORMAT), 
            sprintf($format, ...$params), 
            $trace[1]['class'] . $trace[1]['type'] . $trace[1]['function'],
            $trace[0]['file'], $trace[0]['line']
        );
    }
}
