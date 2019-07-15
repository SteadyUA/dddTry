<?php

use Numbers\Application\Container;
use Numbers\Application\MessageBus\RedisConsumer;
use Numbers\Application\MessageBus\RedisPublisher;
use Numbers\Application\Persistence\DbPersistence;
use Numbers\Application\Persistence\InMemoryPersistence;
use Numbers\Application\Persistence\PersistenceManager;
use Numbers\Application\Repository\SumCounterRepository;
use Numbers\Domain\FibonacciSequenceService;
use Numbers\Domain\PrimeSequenceService;
use Numbers\Domain\SumCounterService;

$container = new Container(include(__DIR__ . '/config.php'));
$container->set('redis', function(Container $container) {
    $redis = new Redis();
    $cfg = $container->cfg('redis');
    $redis->connect($cfg['host'], $cfg['port']);
    if (isset($cfg['password'])) {
        $redis->auth($cfg['password']);
    }
    if (isset($cfg['db'])) {
        $redis->select($cfg['db']);
    }
    return $redis;
});
$container->set('fib.consumer', function(Container $container) {
    return $consumer = new RedisConsumer(
        $container->get('redis'),
        $container->cfg('redis_stream_name')['fib']
    );
});
$container->set('fib.publisher', function(Container $container) {
    return new RedisPublisher(
        $container->get('redis'),
        $container->cfg('redis_stream_name')['fib']
    );
});
$container->set('prime.consumer', function(Container $container) {
    return $consumer = new RedisConsumer(
        $container->get('redis'),
        $container->cfg('redis_stream_name')['prime']
    );
});
$container->set('prime.publisher', function(Container $container) {
    return new RedisPublisher(
        $container->get('redis'),
        $container->cfg('redis_stream_name')['prime']
    );
});
$container->set('db', function(Container $container) {
    $db = $container->cfg('db');
    $dsn = "mysql:dbname={$db['name']};host={$db['host']};port={$db['port']}";
    $user = $db['user'];
    $password = $db['password'];
    return new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
});
$container->set('persistence.manager', function() {
    return new PersistenceManager();
});
$container->set('persistence.sumCounter', function(Container $container) {
//    $persistence = new InMemoryPersistence(true);
    $persistence = new DbPersistence(
        $container->get('db'),
        $container->cfg('table_name')
    );
    $container->get('persistence.manager')->register($persistence);
    return $persistence;
});
$container->set('service.fib.sequence', function() {
    return new FibonacciSequenceService();
});
$container->set('service.prime.sequence', function() {
    return new PrimeSequenceService();
});
$container->set('service.sumCounter', function(Container $container) {
    $persistence = $container->get('persistence.sumCounter');
    return new SumCounterService(new SumCounterRepository($persistence));
});

return $container;
