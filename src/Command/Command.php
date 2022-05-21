<?php
namespace Src\Command;

use Closure;
use Src\Logger\Logger;

interface Command
{
    /**
     * Вызывает callback по переданному идентификатору команды
     *
     * В вызываемом callback, через аргументы, можно получить первым аргументом @var Logger,
     * все последующие аргументы - по порядку переданные argv из консольной строки
     *
     * @param string $command
     * @param Closure $callback
     * @return void
     */
    public function command(string $command, Closure $callback): void;
}