<?php

use Numbers\Application\BasicWorker;
use Numbers\Application\LimitChecker;
use Numbers\Application\MessageGenerator;
use Numbers\Application\MessagePublisher;

require __DIR__ . '/../vendor/autoload.php';
$container = include __DIR__ . '/../container.php';

$options = getopt('', ['count:', 'sleep:']);
$count = $options['count'] ?? null;
$sleepTime = $options['sleep'] ?? 20000; // 0.02sec

$midWare = new MessageGenerator(
    $container->get('service.fib.sequence')
);
$midWare->setNext(new MessagePublisher(
    $container->get('fib.publisher')
))->setNext(
    new LimitChecker($count)
);


(new BasicWorker($midWare, $sleepTime))->run();
