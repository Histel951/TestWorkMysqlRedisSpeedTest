<?php
namespace Src\Database\Factory;

interface Factory
{
    /**
     * Запускает создание записей
     * @return void
     */
    public function run(): void;
}