<?php

namespace Numbers\Application;

use Numbers\Application\MessageBus\PublisherInterface;

class MessagePublisher extends AbstractMiddleware
{
    private $messagePublisher;

    public function __construct(PublisherInterface $messagePublisher)
    {
        $this->messagePublisher = $messagePublisher;
    }

    public function execute(Message $message = null): void
    {
        $this->messagePublisher->publish($message);
        $this->executeNext($message);
    }
}
