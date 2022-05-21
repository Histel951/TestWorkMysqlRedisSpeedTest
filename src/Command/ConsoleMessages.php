<?php
namespace Src\Command;

use Src\Logger\Logger;

class ConsoleMessages implements Logger
{
    public function info(string $text): void
    {
        echo "\x1b[36m{$text}\x1b[0m";
    }

    public function ok(string $text): void
    {
        echo "\x1b[32m{$text}\x1b[0m";
    }

    public function error(string $text): void
    {
        echo "\x1b[31m{$text}\x1b[0m";
    }

    public function nl(): void
    {
        echo "\n";
    }
}