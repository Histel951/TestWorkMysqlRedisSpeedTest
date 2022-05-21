<?php

use Src\Command\Console;
use Src\Database\MysqlConnection;
use Src\Database\RedisConnection;
use Src\Helper\FactoryHelper;
use Src\Helper\MigrationHelper;
use Src\Logger\Logger;
use Src\Time\Stopwatch;

require_once "vendor/autoload.php";

$console = new Console($argv);

$console->command('migrate', function (Logger $consoleLogger) {
    $consoleLogger->nl();
    foreach (MigrationHelper::getAll() as $filePath => $migration) {
        if ($migration->up()) {
            $consoleLogger->ok("migrated: {$filePath}");
        } else {
            $consoleLogger->error("not migrated: {$filePath}");
        }
        $consoleLogger->nl();
    }
    $consoleLogger->nl();
});

$console->command('factory', function (Logger $consoleLogger) {
    $consoleLogger->nl();
    $consoleLogger->info('start creating data.');
    FactoryHelper::factoryMain();

    $consoleLogger->nl();
    $consoleLogger->ok('factory completed successfully!');
    $consoleLogger->nl();
});

$console->command('speed-test:redis:mysql:clear', function (Logger $consoleLogger) {
    $redis = RedisConnection::getInstance()->connection();
    foreach ($redis->keys('test_*') as $key)
    {
        $redis->del($key);
    }

    $mysqlConnection = MysqlConnection::getInstance()->connection();
    $mysqlConnection->query("delete from test;");

    $consoleLogger->nl();
    $consoleLogger->ok('data has been cleared.');
    $consoleLogger->nl();
});

$console->command('speed-test:redis:mysql', function (Logger $consoleLogger) {
    $redis = RedisConnection::getInstance()->connection();

    $redisKeys = $redis->keys('test_*');
    $stopwatch = new Stopwatch();

    $stopwatch->start();
    foreach ($redisKeys as $key)
    {
        $redis->get($key);
    }
    $stopwatch->stop();
    $redisCycleLeadTime = $stopwatch->leadTime();

    $mysql = MysqlConnection::getInstance()->connection();
    $stopwatch->start();
    $mysql->query("select * from test");
    $stopwatch->stop();
    $mysqlLeadTime = $stopwatch->leadTime();

    $stopwatch->start();
    $redis->get('test_large');
    $stopwatch->stop();
    $redisLargeTextTime = $stopwatch->leadTime();

    $consoleLogger->nl();
    $consoleLogger->info('timings:');
    $consoleLogger->nl();
    $consoleLogger->info("Redis 1 large JSON collection time (key: \"test_large\"): {$redisLargeTextTime}");
    $consoleLogger->nl();
    $consoleLogger->info("Redis cycle time (enumeration keys: [test_0, test_1, ...]): {$redisCycleLeadTime}");
    $consoleLogger->nl();
    $consoleLogger->info("MySQL time: {$mysqlLeadTime}");
    $consoleLogger->nl();
});