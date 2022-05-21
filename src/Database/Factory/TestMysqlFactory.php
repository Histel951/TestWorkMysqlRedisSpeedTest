<?php
namespace Src\Database\Factory;

use Src\Database\Seeder\TestMysqlSeeder;
use Src\Helper\ConfigHelper;

class TestMysqlFactory implements Factory
{
    public function run(): void
    {
        (new TestMysqlSeeder)->create(ConfigHelper::config('test_data')->mysql);
    }
}