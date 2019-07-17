<?php

namespace Numbers\Application;

use Numbers\Infrastructure\MessageBus\Message;
use Numbers\Infrastructure\MessageBus\PublisherInterface;

class PublishMessage extends AbstractMiddleware
{
    /** @var PublisherInterface */
    private $publisher;

    /** @var LimitChecker */
    private $limitChecker;

    public function __construct(PublisherInterface $messagePublisher, LimitChecker $limitChecker)
    {
        $this->publisher = $messagePublisher;
        $this->limitChecker = $limitChecker;
    }

    public function execute(Message $message = null): void
    {
        $this->publisher->publish($message);
        $this->executeNext($message);
        if ($this->limitChecker->isLimitReached()) {
            exit(0);
        }
    }
}
