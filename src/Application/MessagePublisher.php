<?php

namespace Numbers\Application;

use Numbers\Application\MessageBus\PublisherInterface;

class MessagePublisher extends AbstractMiddleware
{
    private $messagePublisher;

    /** @var LimitChecker */
    private $limitChecker;

    public function __construct(PublisherInterface $messagePublisher, LimitChecker $limitChecker)
    {
        $this->messagePublisher = $messagePublisher;
        $this->limitChecker = $limitChecker;
    }

    public function execute(Message $message = null): void
    {
        $this->messagePublisher->publish($message);
        $this->executeNext($message);
        if ($this->limitChecker->isLimitReached()) {
            exit(0);
        }
    }
}
