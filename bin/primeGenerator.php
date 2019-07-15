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

$generatorWare = new MessageGenerator($container->get('service.prime.sequence'));
$publisherWare = new MessagePublisher($container->get('prime.publisher'));
$generatorWare->setNext($publisherWare);
if (null !== $count) {
    $publisherWare->setNext(new LimitChecker($count));
}

(new BasicWorker($generatorWare, $sleepTime))->run();
