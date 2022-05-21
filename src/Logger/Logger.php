<?php
namespace Src\Logger;

interface Logger
{
    /**
     * Информационное сообщение
     * @param string $text
     * @return void
     */
    public function info(string $text): void;

    /**
     * Сообщение об успешном выполнении операции
     * @param string $text
     * @return void
     */
    public function ok(string $text): void;

    /**
     * Сообщение об ошибке
     * @param string $text
     * @return void
     */
    public function error(string $text): void;

    /**
     * Новая строка
     * @return void
     */
    public function nl(): void;
}