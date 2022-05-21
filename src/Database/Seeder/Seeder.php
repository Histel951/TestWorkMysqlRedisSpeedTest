<?php
namespace Src\Database\Seeder;

use Faker\Factory;
use Faker\Generator;
use Closure;

abstract class Seeder
{
    /**
     * Фейкер для генерации записей записей с рандом значением
     * @var Generator
     */
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Выполняет операцию определённое количество раз
     * @param int $count
     * @param Closure $callback коллбек вызывающийся count количество раз
     * @param mixed $args агрументы коллбека
     * @return void
     */
    protected function try(int $count, Closure $callback, mixed $args = [])
    {
        for ($iter = 0; $iter < $count; $iter++)
        {
            $callback($iter, ...$args);
        }
    }

    /**
     * Выполняет создание данных где либо
     * @param int $iter
     * @return void
     */
    abstract protected function definition(int $iter): void;

    /**
     * Вызывается вне цикла 1 раз до цикла
     * @return void
     */
    protected function definitionBefore(): void {}

    /**
     * Вызывается вне цикла 1 раз после цикла
     * @return void
     */
    protected function definitionAfter(): void {}

    /**
     * Создаёт записи в базе с переданным количеством
     * @param int $count
     * @return void
     */
    public function create(int $count): void
    {
        $this->definitionBefore();
        $this->try($count, function ($iter) {
            $this->definition($iter);
        });
        $this->definitionAfter();
    }
}