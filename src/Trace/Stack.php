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
use Kovey\Logger\Event\EventInterface;

#[\Attribute]
class Stack implements StackInterface
{
    private string $userId;

    private string $action;

    private string $traceId;

    private Array $stack;

    private Array $drops;

    private Array $consumes;

    private Array $events;

    public function __construct()
    {
        $this->stack = array();
        $this->drops = array();
        $this->consumes = array();
        $this->events = array();
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
            $stack = json_encode($stack, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        $this->stack[] = $stack;
        return $this;
    }

    public function addEvent(EventInterface $event) : self
    {
        $event->setTraceId($this->traceId)
              ->setAction($this->action)
              ->setAppId(Json::getAppId())
              ->setUserId($this->userId);

        $this->events[] = $event;
        return $this;
    }

    public function write(bool $ignoreUserId = false) : void
    {
        if (empty($this->action)) {
            return;
        }

        if (!$ignoreUserId) {
            if (empty($this->userId)) {
                return;
            }
        }

        $appId = Json::getAppId();
        if (empty($appId)) {
            return;
        }

        Json::write(array(
            'app_id' => $appId,
            'user_id' => $this->userId,
            'action' => $this->action,
            'trace_id' => $this->traceId,
            'consumes' => json_encode($this->consumes, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'drops' => json_encode($this->drops, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'stack' => implode('-->', $this->stack),
            'create_time' => date('Y-m-d H:i:s')
        ));

        if (!empty($this->events)) {
            Json::writeEvent($this->events);
        }
    }
}
