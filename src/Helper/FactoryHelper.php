<?php
namespace Src\Helper;

use Src\Config\ConfigException;
use Src\Database\Factory\Factory;

class FactoryHelper
{
    /**
     * Вызов главной фабрики сидов
     * @return void
     * @throws ConfigException
     */
    public static function factoryMain(): void
    {
        $factoryConfig = ConfigHelper::config('database_factory');
        $instance = new $factoryConfig->main_factory;

        if ($instance instanceof Factory) {
            $instance->run();
        }
    }
}