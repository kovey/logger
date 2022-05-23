<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2022-05-23 17:53:05
 *
 */
namespace Kovey\Logger\Trace;

use Kovey\Logger\Logger;

#[\Attribute]
class Stack
{
    private string $appId;

    private string $userId;

    private string $action;

    private string $traceId;

    private Array $stack;

    public function __construct()
    {
        $this->stack = array();
        $this->userId= '';
        $this->action = '';
        $this->traceId = '';
    }

    public function setAppId(string $appId) : self
    {
        $this->appId = $appId;
        return $this;
    }

    public function setUserId(string $userId) : self
    {
        $this->userId = $userId;
        return $this;
    }

    public function setAction(string $action) : self
    {
        $this->action = $action;
        return $this;
    }

    public function setTraceId(string $traceId) : self
    {
        $this->traceId = $traceId;
        return $this;
    }

    public function add(mixed $stack) : self
    {
        $this->stack[] = $stack;
        return $this;
    }

    public function write() : void
    {
        Logger::write(array(
            'app_id' => $this->appId,
            'user_id' => $this->userId,
            'action' => $this->action,
            'trace_id' => $this->traceId,
            'stack' => implode('-->', $this->stack)
        ));
    }
}
