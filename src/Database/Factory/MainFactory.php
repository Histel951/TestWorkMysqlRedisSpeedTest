<?php
namespace Src\Database\Factory;

class MainFactory implements Factory
{
    public function run(): void
    {
        (new RedisFactory)->run();
        (new TestMysqlFactory)->run();
    }
}