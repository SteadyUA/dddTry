<?php

require __DIR__ . '/vendor/autoload.php';

use Numbers\Application\SumCounterService;
use Numbers\DiContainer;
use Numbers\Infrastructure\MessageBus\RedisConsumer;
use Numbers\Infrastructure\MessageBus\RedisPublisher;
use Numbers\Infrastructure\Persistence\DbPersistence;
use Numbers\Infrastructure\Persistence\InMemoryPersistence;
use Numbers\Infrastructure\Persistence\TransactionManager;
use Numbers\Infrastructure\Persistence\SumCounterRepository;
use Numbers\Domain\FibonacciSequenceService;
use Numbers\Domain\PrimeSequenceService;

$container = new DiContainer(include(__DIR__ . '/config.php'));
$container->set('redis', function(DiContainer $container) {
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
$container->set('fib.consumer', function(DiContainer $container) {
    return $consumer = new RedisConsumer(
        $container->get('redis'),
        $container->cfg('redis_stream_name')['fib']
    );
});
$container->set('fib.publisher', function(DiContainer $container) {
    return new RedisPublisher(
        $container->get('redis'),
        $container->cfg('redis_stream_name')['fib']
    );
});
$container->set('prime.consumer', function(DiContainer $container) {
    return $consumer = new RedisConsumer(
        $container->get('redis'),
        $container->cfg('redis_stream_name')['prime']
    );
});
$container->set('prime.publisher', function(DiContainer $container) {
    return new RedisPublisher(
        $container->get('redis'),
        $container->cfg('redis_stream_name')['prime']
    );
});
$container->set('db', function(DiContainer $container) {
    $db = $container->cfg('db');
    $dsn = "mysql:dbname={$db['name']};host={$db['host']};port={$db['port']}";
    $user = $db['user'];
    $password = $db['password'];
    return new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
});
$container->set('persistence.manager', function() {
    return new TransactionManager();
});
$container->set('persistence.sumCounter', function(DiContainer $container) {
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
$container->set('service.sumCounter', function(DiContainer $container) {
    $persistence = $container->get('persistence.sumCounter');
    return new SumCounterService(new SumCounterRepository($persistence));
});

return $container;
