<?php

//Backend to store Session in Redis.
include_once "SessionInterface.php";    //Interface for the Backend Operation

class RedisStorage implements SessionInterface
{
    private $redisHost;
    private $redisPort;

    public function __construct()
    {
        $this->redisHost = "127.0.0.1";    // Redis host
        $this->redisPort = 6379;           // Redis port
    }

    public function storeSession($name, $content)
    {
        $redis = new Redis();
        $redis->pconnect($this->redisHost,  $this->redisHost);
        $redis->setEx($name, 300, $content);
    }

    public function updateSession($name, $content)
    {
        $redis = new Redis();
        $redis->pconnect($this->redisHost,  $this->redisHost);
        $redis->setEx($name, 300, $content);
    }

    public function readSession($name)
    {
        $redis = new Redis();
        $redis->pconnect($this->redisHost,  $this->redisHost);
        return $redis->get($name);
    }
}
