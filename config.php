<?php

return [
    'redis' => [
        'host' => 'localhost',
        'port' => '6379',
        'password' => null,
        'db' => null,
    ],
    'redis_stream_name' => [
        'fib' => 'fib-seq',
        'prime' => 'prime-seq',
    ],
    'db' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'user' => 'test',
        'password' => 'test',
        'name' => 'test'
    ],
    'table_name' => 'sumCount'
];
