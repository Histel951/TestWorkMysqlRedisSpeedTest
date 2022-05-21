<?php
namespace Src\Database;

use mysqli;
use Src\Config\Config;
use Src\Helper\ConfigHelper;

class MysqlConnection implements Connection
{
    private static array $instances = [];

    /**
     * Конфиги для подключения к базе
     * @var Config
     */
    private Config $config;

    /**
     * Подключение к базе
     * @var mysqli
     */
    private mysqli $connection;

    private function __construct()
    {
        $this->config = ConfigHelper::config('database_connection');
        $this->connection = new mysqli(
            hostname: $this->config->hostname,
            username: $this->config->username,
            password: $this->config->password,
            database: $this->config->database
        );
    }

    public function connection(): mysqli
    {
        return $this->connection;
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