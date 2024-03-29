<?php

namespace Numbers\Application;

use Numbers\Infrastructure\MessageBus\ConsumerInterface;
use Numbers\Infrastructure\MessageBus\Message;
use Throwable;

class ConsumeMessage extends AbstractMiddleware
{
    private $consumer;
    private $limitChecker;

    public function __construct(ConsumerInterface $consumer, LimitChecker $limitChecker)
    {
        $this->consumer = $consumer;
        $this->limitChecker = $limitChecker;
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

        if ($this->limitChecker->isLimitReached()) {
            exit(0);
        }
    }
}
