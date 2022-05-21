<?php
namespace Src\Database\Migration;

use Src\Database\MysqlConnection;

return new class implements Migration
{
    public function up(): bool
    {
        return MysqlConnection::getInstance()->connection()->query("
            create table if not exists test (
                `id` int not null auto_increment,
                `text` text,
                primary key (`id`)
            );");
    }

    public function down(): bool
    {
        return MysqlConnection::getInstance()->connection()->query("
            drop table if exists test;
        ");
    }
};
