<?php

namespace Numbers\Application\MessageBus;

use Numbers\Application\Message;

interface ConsumerInterface
{
    public function pull(): ?Message;
    public function ack(): void;
}
