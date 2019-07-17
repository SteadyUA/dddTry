<?php

use Numbers\Application\BasicWorker;
use Numbers\Application\LimitChecker;
use Numbers\Application\GenerateMessage;
use Numbers\Application\PublishMessage;

$container = include __DIR__ . '/../container.php';

$options = getopt('', ['count:', 'sleep:']);
$count = $options['count'] ?? null;
$sleepTime = $options['sleep'] ?? 20000; // 0.02sec

$generateMessage = new GenerateMessage(
    $container->get('service.fib.sequence')
);
$publishMessage = new PublishMessage(
    $container->get('fib.publisher'),
    new LimitChecker($count)
);
$generateMessage->setNext($publishMessage);

(new BasicWorker($generateMessage, $sleepTime))->run();
