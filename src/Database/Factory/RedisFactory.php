<?php
namespace Src\Database\Factory;

use Src\Database\Seeder\RedisSeeder;
use Src\Helper\ConfigHelper;

class RedisFactory implements Factory
{
    public function run(): void
    {
        (new RedisSeeder)->create(ConfigHelper::config('test_data')->redis);
    }
}