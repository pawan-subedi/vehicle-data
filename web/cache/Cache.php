
<?php

// require_once('CacheInterface.php');
// class Cache implements CacheInterface
// {

//     const MEMCACHE_PORT = 11211; //Move to config
//     const MEMCACHE_HOST = "localhost";

//     protected $initialized = false;

//     /** @var Memcache */
//     protected $adapter = null;

//     public function __construct()
//     {
//         $this->init();
//     }

//     public function get($key, $default = null)
//     {
//         return $this->adapter->get($key, $default);
//     }

//     public function set($key, $value, $ttl = null)
//     {
//         $this->adapter->set($key, $value, $ttl);
//     }

//     public function delete($key)
//     {
//         $this->adapter->delete($key);
//     }

//     public function has($key)
//     {
//         //todo : implement
//     }

//     public function init(){
//         if (!$this->initialized) {
//             $this->adapter = new Memcache;
//             $this->adapter->connect(self::MEMCACHE_HOST,self::MEMCACHE_PORT);
//             $this->initialized = true;
//         }
//     }

//     /**
//      * @return bool
//      */
//     public function isInitialized(): bool
//     {
//         return $this->initialized;
//     }

//     /**
//      * @param bool $initialized
//      */
//     public function setInitialized(bool $initialized): void
//     {
//         $this->initialized = $initialized;
//     }

//     /**
//      * @return null
//      */
//     public function getAdapter()
//     {
//         return $this->adapter;
//     }

//     /**
//      * @param null $adapter
//      */
//     public function setAdapter($adapter): void
//     {
//         $this->adapter = $adapter;
//     }


// } 