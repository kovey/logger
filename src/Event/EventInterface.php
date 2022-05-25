<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2022-05-25 10:56:38
 *
 */
namespace Kovey\Logger\Event;

interface EventInterface
{
    public function setAppId(string $appId) : self;

    public function setUserId(string $userId) : self;

    public function setAction(string $action) : self;

    public function setTraceId(string $traceId) : self;

    public function toArray() : Array;

    public function getName() : string;
}
