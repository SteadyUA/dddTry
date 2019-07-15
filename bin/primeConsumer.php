<?php

use Numbers\Application\BasicWorker;
use Numbers\Application\LimitChecker;
use Numbers\Application\ConsumeMessage;
use Numbers\Application\ProcessMessage;

require __DIR__ . '/../vendor/autoload.php';
$container = include __DIR__ . '/../container.php';

$options = getopt('', ['count:', 'sleep:']);
$count = $options['count'] ?? null;
$sleepTime = $options['sleep'] ?? 20000; // 0.02sec

$consumeMessage = new ConsumeMessage(
    $container->get('prime.consumer'),
    new LimitChecker($count)
);
$processMessage = new ProcessMessage(
    $container->get('persistence.manager'),
    $container->get('service.sumCounter'),
    'sum-count_prime'
);
$consumeMessage->setNext($processMessage);

(new BasicWorker($consumeMessage, $sleepTime))->run();
