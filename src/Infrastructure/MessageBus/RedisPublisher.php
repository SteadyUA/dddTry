<?php

namespace Numbers\Application\MessageBus;

use Numbers\Application\Message;
use Redis;

class RedisPublisher implements PublisherInterface
{
    private $redis;
    private $streamName;

    public function __construct(Redis $redis, string $streamName)
    {
        $this->redis = $redis;
        $this->streamName = $streamName;
    }

    public function publish(Message $message): void
    {
        $entryId = '1-' . $message->id();
        $entryData = [
            'id' => $message->id(),
            'num' => $message->number()->toString(),
        ];
        $this->redis->xAdd($this->streamName, $entryId, $entryData);
    }
}
