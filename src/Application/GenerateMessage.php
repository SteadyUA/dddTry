<?php

namespace Numbers\Application;

use Numbers\Domain\AbstractSequenceService;
use Numbers\Infrastructure\MessageBus\Message;

class GenerateMessage extends AbstractMiddleware
{
    private $sequence;

    public function __construct(AbstractSequenceService $sequence)
    {
        $this->sequence = $sequence;
    }

    public function execute(Message $message = null): void
    {
        $number = $this->sequence->getNextNumber();
        $message = Message::create($number);
        $this->executeNext($message);
    }
}
