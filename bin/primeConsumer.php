<?php

use Numbers\Application\BasicWorker;
use Numbers\Application\LimitChecker;
use Numbers\Application\MessageConsumer;
use Numbers\Application\MessageProcessor;

require __DIR__ . '/../vendor/autoload.php';
$container = include __DIR__ . '/../container.php';

$options = getopt('', ['count:', 'sleep:']);
$count = $options['count'] ?? null;
$sleepTime = $options['sleep'] ?? 20000; // 0.02sec

$consumeWare = new MessageConsumer($container->get('prime.consumer'), new LimitChecker($count));
$processWare = new MessageProcessor(
    $container->get('persistence.manager'),
    $container->get('service.sumCounter'),
    'sum-count_prime'
);
$consumeWare->setNext($processWare);

(new BasicWorker($consumeWare, $sleepTime))->run();
