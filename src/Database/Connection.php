<?php
namespace Src\Database;

interface Connection
{
    /**
     * Метод возвращающий подключение к базе
     * @return mixed
     */
    public function connection();
}