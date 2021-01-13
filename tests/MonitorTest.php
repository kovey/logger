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

class MonitorTest extends TestCase
{
    public function testDbSetDir()
    {
        Monitor::setLogDir(__DIR__ . '/log');
        $this->assertTrue(is_dir(__DIR__ . '/log'));
    }

    public function testWrite()
    {
        Monitor::setLogDir(__DIR__ . '/log');
        Monitor::write(array('kovey' => 'framework'));
        System::sleep(0.1);
        $this->assertFileExists(__DIR__ . '/log/monitor/' . date('Y-m-d') . '.log');
        $log = json_decode(file_get_contents(__DIR__ . '/log/monitor/' . date('Y-m-d') . '.log'), true);
        $this->assertEquals(array('kovey' => 'framework'), $log);
    }

    public static function tearDownAfterClass() : void
    {
        if (is_file(__DIR__ . '/log/monitor/' . date('Y-m-d') . '.log')) {
            unlink(__DIR__ . '/log/monitor/' . date('Y-m-d') . '.log');
        }
        if (is_dir(__DIR__ . '/log/monitor')) {
            rmdir(__DIR__ . '/log/monitor');
        }
        if (is_dir(__DIR__ . '/log')) {
            rmdir(__DIR__ . '/log');
        }
    }
}
