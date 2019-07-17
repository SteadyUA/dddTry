<?php

namespace Numbers\Infrastructure\MessageBus;

interface ConsumerInterface
{
    public function pull(): ?Message;
    public function ack(): void;
}
