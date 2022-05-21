<?php
namespace Src\Database;

use Src\Config\Config;
use Redis;
use Src\Helper\ConfigHelper;

class RedisConnection implements Connection
{
    private static array $instances = [];

    /**
     * Конфиги для подключения к редису
     * @var Config
     */
    protected Config $config;

    /**
     * Подключение к редису
     * @var Redis
     */
    private Redis $redis;

    private function __construct()
    {
        $this->config = ConfigHelper::config('redis_connection');

        $this->redis = new Redis();
        $this->redis->connect(host: $this->config->hostname, port: $this->config->port);
        $this->redis->ping();
    }

    public function connection(): Redis
    {
        return $this->redis;
    }

    public static function getInstance(): self
    {
        $class = self::class;
        if (empty(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        return self::$instances[$class];
    }
}