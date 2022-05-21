<?php

namespace Src\Command;

use Closure;

class Console implements Command
{
    /**
     * Массив аргументов передающийся из выполняемого файла
     * @var array
     */
    private array $argv;

    public function __construct(array $argv)
    {
        $this->argv = $argv;
    }

    public function command(string $command, Closure $callback): void
    {
        if ($this->argv[1] === $command) {
            $callback(new ConsoleMessages(), ...$this->argv);
            return;
        }
    }
}