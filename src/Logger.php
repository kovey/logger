<?php
/**
 *
 * @description logger manager
 *
 * @package     Logger
 *
 * @time        Tue Sep 24 09:06:05 2019
 *
 * @author      kovey
 */
namespace Kovey\Logger;

class Logger
{
    /**
     * @description info logger directory
     *
     * @var string
     */
    private static string $infoPath;

    /**
     * @description exception logger directory
     *
     * @var string
     */
    private static string $exceptionPath;

    /**
     * @description error logger directory
     *
     * @var string
     */
    private static string $errorPath;

    /**
     * @description warning logger directory
     *
     * @var string
     */
    private static string $warningPath;

    /**
     * @description business logger directory
     *
     * @var string
     */
    private static string $busiPath;

    /**
     * @description logger category
     *
     * @var string
     */
    private static string $category = '';

    /**
     * @description set logger directory
     *
     * @param string $dir
     *
     * @return void
     */
    public static function setLogPath(string $dir) : void
    {
        self::$infoPath = $dir . '/info';
        if (!is_dir(self::$infoPath)) {
            mkdir(self::$infoPath, 0777, true);
        }

        self::$exceptionPath = $dir . '/exception';
        if (!is_dir(self::$exceptionPath)) {
            mkdir(self::$exceptionPath, 0777, true);
        }

        self::$errorPath = $dir . '/error';
        if (!is_dir(self::$errorPath)) {
            mkdir(self::$errorPath, 0777, true);
        }

        self::$warningPath = $dir . '/warning';
        if (!is_dir(self::$warningPath)) {
            mkdir(self::$warningPath, 0777, true);
        }

        self::$busiPath = $dir . '/busi_exception';
        if (!is_dir(self::$busiPath)) {
            mkdir(self::$busiPath, 0777, true);
        }
    }

    /**
     * @description write info logger content into file
     *
     * @param int $line
     *
     * @param string $file
     *
     * @param string | Array $msg
     *
     * @return void
     */
    public static function writeInfoLog(int $line, string $file, string | Array $msg, string $traceId = '') : void
    {
        go (function (int $line, string $file, string | Array $msg, string $traceId) {
            $content = array(
                'time' => date('Y-m-d H:i:s'),
                'category' => self::$category,
                'type' => 'Info',
                'message' => $msg,
                'trace' => '',
                'line' => $line,
                'file' => $file,
                'traceId' => $traceId
            );
            file_put_contents(
                self::$infoPath . '/' . date('Y-m-d') . '.log',
                json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL,
                FILE_APPEND
            );
        }, $line, $file, $msg, $traceId);
    }

    /**
     * @description write error logger content into file
     *
     * @param int $line
     *
     * @param string $file
     *
     * @param string | Array $msg
     *
     * @return void
     */
    public static function writeErrorLog(int $line, string $file, string | Array $msg, string $traceId = '') : void
    {
        go (function (int $line, string $file, string | Array $msg, string $traceId) {
            $content = array(
                'time' => date('Y-m-d H:i:s'),
                'category' => self::$category,
                'type' => 'Error',
                'message' => $msg,
                'trace' => '',
                'line' => $line,
                'file' => $file,
                'traceId' => $traceId
            );
            file_put_contents(
                self::$errorPath . '/' . date('Y-m-d') . '.log',
                json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL,
                FILE_APPEND
            );
        }, $line, $file, $msg, $traceId);
    }

    /**
     * @description write warning logger content into file
     *
     * @param int $line
     *
     * @param string $file
     *
     * @param string | Array $msg
     *
     * @param string $traceId
     *
     * @return void
     */
    public static function writeWarningLog(int $line, string $file, string | Array $msg, string $traceId = '') : void
    {
        go (function (int $line, string $file, string | Array $msg, string $traceId) {
            $content = array(
                'time' => date('Y-m-d H:i:s'),
                'category' => self::$category,
                'type' => 'Warning',
                'message' => $msg,
                'trace' => '',
                'line' => $line,
                'file' => $file,
                'traceId' => $traceId
            );
            file_put_contents(
                self::$warningPath . '/' . date('Y-m-d') . '.log',
                json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL,
                FILE_APPEND
            );
        }, $line, $file, $msg, $traceId);
    }

    /**
     * @description write exception logger content into file
     *
     * @param int $line
     *
     * @param string $file
     *
     * @param Array | Throwable $e
     *
     * @param string $traceId
     *
     * @return void
     */
    public static function writeExceptionLog(int $line, string $file, \Throwable $e, string $traceId = '') : void
    {
        go (function (int $line, string $file, \Throwable $e, string $traceId) {
            $content = array(
                'time' => date('Y-m-d H:i:s'),
                'category' => self::$category,
                'type' => 'Exception',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $line,
                'file' => $file,
                'traceId' => $traceId
            );
            file_put_contents(
                self::$exceptionPath . '/' . date('Y-m-d') . '.log',
                json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL,
                FILE_APPEND
            );
        }, $line, $file, $e, $traceId);
    }

    /**
     * @description set logger category
     *
     * @param string $category
     *
     * @return void
     */
    public static function setCategory(string $category) : void
    {
        self::$category = $category;
    }

    /**
     * @description write business logger content into file
     *
     * @param int $line
     *
     * @param string $file
     *
     * @param Array | Throwable $e
     *
     * @param string $traceId
     *
     * @return void
     */
    public static function writeBusiException(int $line, string $file, \Throwable $e, string $traceId = '') : void
    {
        go (function (int $line, string $file, \Throwable $e, string $traceId) {
            $content = array(
                'time' => date('Y-m-d H:i:s'),
                'category' => self::$category,
                'type' => 'BusiException',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $line,
                'file' => $file,
                'traceId' => $traceId
            );
            file_put_contents(
                self::$busiPath . '/' . date('Y-m-d') . '.log',
                json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL,
                FILE_APPEND
            );
        }, $line, $file, $e, $traceId);
    }

    /**
     * @description write warning logger content into file with sync
     *
     * @param int $line
     *
     * @param string $file
     *
     * @param string | Array $msg
     *
     * @param string $traceId
     *
     * @return void
     */
    public static function writeWarningLogSync(int $line, string $file, string | Array $msg, string $traceId = '') : void
    {
        $content = array(
            'time' => date('Y-m-d H:i:s'),
            'category' => self::$category,
            'type' => 'Warning',
            'message' => $msg,
            'trace' => '',
            'line' => $line,
            'file' => $file,
            'traceId' => $traceId
        );
        file_put_contents(
            self::$warningPath . '/' . date('Y-m-d') . '.log',
            json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL,
            FILE_APPEND
        );
    }
}
