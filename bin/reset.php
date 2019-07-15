<?php

require __DIR__ . '/../vendor/autoload.php';
$container = include __DIR__ . '/../container.php';

/** @var Redis $redis */
$redis = $container->get('redis');
$redis->del($container->cfg('redis_stream_name')['fib']);
$redis->del($container->cfg('redis_stream_name')['prime']);

$tableName = $container->cfg('table_name');
$queryList = [
    "DROP TABLE IF EXISTS `{$tableName}`",
    "CREATE TABLE `{$tableName}` (`sum` TEXT, `count_fib` INT UNSIGNED, `count_prime` INT UNSIGNED) ENGINE=InnoDB",
    "INSERT INTO `{$tableName}` VALUES('0', 0, 0)",
];
/** @var PDO $db */
$db = $container->get('db');
foreach ($queryList as $query) {
    $db->exec($query);
}
