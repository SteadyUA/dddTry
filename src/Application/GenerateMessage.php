<?php

namespace Numbers\Application;

use Numbers\Domain\AbstractSequenceService;

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
        $message = new Message($number, Message::generateNextId());
        $this->executeNext($message);
    }
}
