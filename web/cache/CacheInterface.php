<?php


interface CacheInterface
{
    public function get($key, $default = null);

    public function set($key, $value, $ttl = null);

    public function delete($key);

    public function has($key);
}