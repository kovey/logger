<?php
/**
 * @description 默认事件
 *
 * @package
 *
 * @author kovey
 *
 * @time 2022-05-25 11:02:49
 *
 */
namespace Kovey\Logger\Event;

class Defa implements EventInterface
{
    private string $name;

    private string $userId = '';

    private string $action = '';

    private string $traceId = '';

    private string $appId = '';

    private int $result = -1; // event result

    private int $ext = -1;

    private int $ext1 = -1;

    private int $ext2 = -1;

    private string $ext3 = '';

    private Array $ext4 = array();

    public function __construct(string $name)
    {
        $this->name = $name;
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

    public function setResult(int $result) : self
    {
        $this->result = $result;
        return $this;
    }

    public function setExt(int $ext) : self
    {
        $this->ext = $ext;
        return $this;
    }
    
    public function setExt1(int $ext1) : self
    {
        $this->ext1 = $ext1;
        return $this;
    }

    public function setExt2(int $ext2) : self
    {
        $this->ext2 = $ext2;
        return $this;
    }

    public function setExt3(string $ext3) : self
    {
        $this->ext3 = $ext3;
        return $this;
    }

    public function setExt4(Array $ext4) : self
    {
        $this->ext4 = $ext4;
        return $this;
    }

    public function toArray() : Array
    {
        return array(
            'name' => $this->name,
            'action' => $this->action,
            'user_id' => $this->userId,
            'trace_id' => $this->traceId,
            'result' => $this->result,
            'app_id' => $this->appId,
            'ext' => $this->ext,
            'ext1' => $this->ext1,
            'ext2' => $this->ext2,
            'ext3' => $this->ext3,
            'ext4' => json_encode($this->ext4, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );
    }

    public function getName() : string
    {
        return $this->name;
    }
}
