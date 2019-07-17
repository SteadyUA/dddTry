<?php

namespace Numbers\Infrastructure\MessageBus;

interface PublisherInterface
{
    public function publish(Message $message): void;
}
