<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2022-05-25 10:49:33
 *
 */
namespace Kovey\Logger\Trace;

use Kovey\Logger\Event\EventInterface;

interface StackInterface
{
    public function setUserId(string $userId) : self;

    public function setAction(string $action) : self;

    public function setTraceId(string $traceId) : self;

    public function add(string | Array $data) : self;

    public function addEvent(EventInterface $event) : self;

    public function write(bool $ignoreUserId = false) : void;
}
