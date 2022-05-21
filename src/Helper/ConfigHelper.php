<?php
namespace Src\Helper;

use Src\Config\Config;
use Src\Config\ConfigException;

class ConfigHelper
{
    /**
     * Директория с конфиг файлами
     * @var string
     */
    public const CONFIG_DIR = 'config';

    /**
     * Возвращает конфиги по имени файла
     * @param string $name
     * @return Config
     * @throws ConfigException
     */
    public static function config(string $name): Config
    {
        return new Config(self::CONFIG_DIR, $name);
    }
}