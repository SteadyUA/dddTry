<?php

namespace Numbers\Application;

use InvalidArgumentException;
use Numbers\Application\MessageBus\ConsumerInterface;
use Throwable;

class MessageConsumer extends AbstractMiddleware
{
    private $consumer;

    public function __construct(ConsumerInterface $consumer)
    {
        $this->consumer = $consumer;
    }

    /**
     * @param Message|null $message
     * @throws Throwable
     */
    public function execute(Message $message = null): void
    {
        $message = $this->consumer->pull();
        if (empty($message)) {
            return;
        }

        try {
            $this->executeNext($message);
            $this->consumer->ack();
        } catch (Throwable $ex) {
            throw $ex;
        }
    }
}
