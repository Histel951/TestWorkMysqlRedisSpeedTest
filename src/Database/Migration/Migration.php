<?php
namespace Src\Database\Migration;

interface Migration
{
    /**
     * Создаёт таблицу в базе
     * @return void
     */
    public function up(): bool;

    /**
     * Удаляет таблицу из базы
     * @return void
     */
    public function down(): bool;
}