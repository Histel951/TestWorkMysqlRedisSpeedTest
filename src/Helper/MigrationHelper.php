<?php
namespace Src\Helper;

use Src\Database\Migration\Migration;
use Src\Config\ConfigException;

class MigrationHelper
{
    /**
     * Возвращает все сущности миграций в массиве
     * @return Migration[]
     * @throws ConfigException
     */
    public static function getAll(): array
    {
        $migrations = [];
        $migrationConfig = ConfigHelper::config('database_migration');
        foreach (scandir($migrationConfig->migration_dir) as $migrationFile) {

            if (str_starts_with($migrationFile, 'create_table_')) {
                $filePath = "{$migrationConfig->migration_dir}/$migrationFile";
                $migration = include $filePath;

                if ($migration instanceof Migration) {
                    $migrations[$filePath] = $migration;
                }
            }
        }

        return $migrations;
    }
}