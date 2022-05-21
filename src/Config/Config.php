<?php
namespace Src\Config;

class Config
{
    /**
     * Массив конфигов из файла
     * @var array
     */
    protected array $configs;

    /**
     * Значение конфигов по умолчанию
     * @var string
     */
    protected string $activeConfig = 'default';

    /**
     * Директория с конфиг файлами
     * @var string
     */
    protected string $configDir;

    /**
     * Максимальное количество итераций при рекурсивном поиске файла с конфигами
     * @var int
     */
    private int $maxFindIterations = 20;

    /**
     * @param string $file название файлика с конфигами
     * @throws ConfigException
     */
    public function __construct(string $configDir, string $file)
    {
        $this->configDir = $configDir;
        $filePath = "{$_SERVER['DOCUMENT_ROOT']}/{$this->configDir}/{$file}.php";

        if (file_exists($file)) {
            $this->configs = include $filePath;
        } else {
            $this->configs = include "{$this->findRecursiveConfigFiles()}/{$file}.php";
        }
    }

    /**
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name = 'default'): mixed
    {
        if ($this->activeConfig === $name) {
            return $this->$name;
        }

        return $this->configs[$name];
    }

    /**
     * Возвращает все конфиги из файла
     * @return array
     */
    public function getAll(): array
    {
        return $this->configs;
    }

    /**
     * Возвращает значение конфига по активному конфигу по названию
     * при вызове свойства от инициализированного класса
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        if ($config = $this->configs[$this->activeConfig][$name]) {
            return $config;
        }

        return null;
    }

    /**
     * Ищет рекурсивно вверх директорию с конфиг файлами
     * Возвращает локальный путь к конфиг директории
     * @param string $dir текущая директория с которой начинается поиск
     * @param int $iter ограничение по количеству итераций *20*
     * @return string
     * @throws ConfigException
     */
    private function findRecursiveConfigFiles(string $dir = __DIR__, int $iter = 0): string
    {
        if ($iter > $this->maxFindIterations) {
            throw new ConfigException('Too many search iterations, config directory not found.');
        }

        if ($files = scandir($dir)) {
            foreach ($files as $item)
            {
                if ($item === $this->configDir) {
                    return "{$dir}/$item";
                }
            }

            return $this->findRecursiveConfigFiles("{$dir}/..", ++$iter);
        }

        return $this->findRecursiveConfigFiles("{$dir}/..", ++$iter);
    }
}