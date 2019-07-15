<?php

namespace Numbers\Application\MessageBus;

use Numbers\Application\Message;
use Numbers\Domain\NumberValue;
use Redis;

class RedisConsumer implements ConsumerInterface
{
    const GROUP_NAME = 'numbers1';
    const CONSUMER_NAME = 'consumer';

    private $redis;
    private $streamName;
    private $currentId;

    public function __construct(Redis $redis, string $streamName)
    {
        $this->redis = $redis;
        $this->streamName = $streamName;

        // create stream
        if ($redis->exists($streamName) == 0) {
            if ($redis->xAdd($streamName, '0-1', ['ctrl' => 'init'])) {
                $redis->xDel($streamName, ['0-1']);
            }
        }
        // create group
        $redis->xGroup('CREATE', $streamName, self::GROUP_NAME, '0');
    }

    public function pull(): ?Message
    {
        $messages = $this->redis->xReadGroup(
            self::GROUP_NAME,
            self::CONSUMER_NAME,
            [$this->streamName => '>'],
            1
        );
        if (empty($messages[$this->streamName])) {
            return null;
        }
        $this->currentId = key($messages[$this->streamName]);
        $data = $messages[$this->streamName][$this->currentId];

        return new Message(new NumberValue($data['num']), $data['id']);
    }

    public function ack(): void
    {
        $this->redis->xAck($this->streamName, self::GROUP_NAME, [$this->currentId]);
    }
}
