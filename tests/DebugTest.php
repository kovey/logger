<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2021-07-21 19:55:19
 *
 */
namespace Kovey\Logger;

use PHPUnit\Framework\TestCase;

class DebugTest extends TestCase
{
    public function testInfo()
    {
        Debug::setLevel(Debug::LOG_LEVEL_NO);
        Debug::info('test info, array: %s', array('1', '2', '5'));
        Debug::debug('test info, array: %s', array('1', '2', '5'));
        Debug::warning('test info, array: %s', array('1', '2', '5'));
        Debug::error('test info, array: %s', array('1', '2', '5'));
    }
}
