<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2020-10-19 18:22:56
 *
 */
namespace Kovey\Logger;

use PHPUnit\Framework\TestCase;
use Swoole\Coroutine\System;

class DbTest extends TestCase
{
    public function testDbSetDir()
    {
        Db::setLogDir(__DIR__ . '/log');
        $this->assertTrue(is_dir(__DIR__ . '/log'));
    }

    public function testWrite()
    {
        Db::setLogDir(__DIR__ . '/log');
        Db::write('SELECT * FROM test Where id = 1', 0.0145);
        System::sleep(0.1);
        $this->assertFileExists(__DIR__ . '/log/db/' . date('Y-m-d') . '.log');
        $log = json_decode(file_get_contents(__DIR__ . '/log/db/' . date('Y-m-d') . '.log'), true);
        $this->assertEquals('SELECT * FROM test Where id = 1', $log['sql']);
        $this->assertEquals('14.5ms', $log['delay']);
    }

    public static function tearDownAfterClass() : void
    {
        if (is_file(__DIR__ . '/log/' . date('Y-m-d') . '.log')) {
            unlink(__DIR__ . '/log/' . date('Y-m-d') . '.log');
        }
        if (is_dir(__DIR__ . '/log/db')) {
            rmdir(__DIR__ . '/log/db');
        }
        if (is_dir(__DIR__ . '/log')) {
            rmdir(__DIR__ . '/log');
        }
    }
}
