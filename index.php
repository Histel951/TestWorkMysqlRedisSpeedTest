<?php

use Src\Database\MysqlConnection;

require_once "vendor/autoload.php";

$redis = \Src\Database\RedisConnection::getInstance()->connection();

var_dump(json_decode($redis->get("test_large"), true));