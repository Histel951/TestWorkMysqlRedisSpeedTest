<?php
namespace Src\Database\Seeder;

use Src\Database\MysqlConnection;

class TestMysqlSeeder extends Seeder
{
    public function definition(int $iter): void
    {
        MysqlConnection::getInstance()->connection()->query("
            INSERT INTO
                test (id, text)
             VALUES (null, '{$this->faker->text(1000)}');
        ");
    }
}