<?php
namespace Src\Database\Seeder;

use Src\Database\RedisConnection;

class RedisSeeder extends Seeder
{
    protected function definitionBefore(): void
    {
        $redis = RedisConnection::getInstance()->connection();
        $redis->set('test_large', '');
    }

    public function definition(int $iter): void
    {
        $redis = RedisConnection::getInstance()->connection();
        $jsonObject = json_encode([
            'id' => $iter,
            'text' => $this->faker->realTextBetween(1000, 2000)
        ]);

        $redis->set("test_{$iter}", $jsonObject);
        $redis->append('test_large', "{$jsonObject},");
    }

    protected function definitionAfter(): void
    {
        // только для того чтобы данные соответствовали JSON коллекции
        $redis = RedisConnection::getInstance()->connection();
        $largeText = $redis->get('test_large');
        $largeText = substr($largeText, 0, -1);
        $redis->set('test_large', "[{$largeText}]");
    }
}