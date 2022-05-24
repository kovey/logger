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

use Kovey\Logger\Json;

#[\Attribute]
class Stack
{
    private string $userId;

    private string $action;

    private string $traceId;

    private Array $stack;

    private Array $drops;

    private Array $consumes;

    public function __construct()
    {
        $this->stack = array();
        $this->drops = array();
        $this->consumes = array();
        $this->userId= '';
        $this->action = '';
        $this->traceId = '';
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

    public function setDrops(Array $drops) : self
    {
        $this->drops = $drops;
        return $this;
    }

    public function setConsumes(Array $consumes) : self
    {
        $this->consumes = $consumes;
        return $this;
    }

    public function add(string | Array $stack) : self
    {
        if (is_array($stack)) {
            $stack = json_encode($stack);
        }

        $this->stack[] = $stack;
        return $this;
    }

    public function write() : void
    {
        $appId = Json::getAppId();
        if (empty($appId)) {
            return;
        }

        Json::write(array(
            'app_id' => $appId,
            'user_id' => $this->userId,
            'action' => $this->action,
            'trace_id' => $this->traceId,
            'consumes' => json_encode($this->consumes),
            'drops' => json_encode($this->drops),
            'stack' => implode('-->', $this->stack)
        ));
    }
}
