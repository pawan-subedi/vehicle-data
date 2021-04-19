<?php
require_once('CacheInterface.php');

class RedisAdapter implements CacheInterface
{

    const REDIS_HOST = "redis";

    const REDIS_PORT = "6379";

    protected $initialized = false;

    /**
     * @var RedisAdapter
     */
    protected $adapter = null;

    public function __construct()
    {
        $this->init();
    }

    public function get($key, $default = null)
    {
        return $this->adapter->get($key);
    }

    public function set($key, $value, $ttl = null)
    {
        $this->adapter->set($key, $value, $ttl);
    }

    public function delete($key)
    {
        $this->adapter->del($key);
    }

    public function has($key)
    {
        return $this->adapter->has($key);
    }

    public function init()
    {
        if (!$this->initialized) {
            $this->adapter = new Redis;
            $this->adapter->connect(self::REDIS_HOST, self::REDIS_PORT);
            $this->initialized = true;
        }
    }
}