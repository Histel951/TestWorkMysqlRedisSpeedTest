<?php
namespace Src\Time;

class Stopwatch
{
    /**
     * Время запуска таймера
     * @var float
     */
    private float $start;

    /**
     * Время остановки таймера
     * @var float
     */
    private float $stop;

    public function __construct()
    {
        $this->start = 0;
        $this->stop = 0;
    }

    /**
     * Записывает время запуска
     * @return void
     */
    public function start(): void
    {
        $this->start = microtime(true);
    }

    /**
     * Записывает время остановки
     * @return void
     */
    public function stop(): void
    {
        $this->stop = microtime(true);
    }

    /**
     * Возвращает время выполнения
     * @return float
     */
    public function leadTime(): float
    {
        $different = $this->stop - $this->start;
        $this->clear();
        return $different;
    }

    /**
     * Очищает результат замера
     * @return void
     */
    private function clear()
    {
        $this->start = 0;
        $this->stop = 0;
    }
}