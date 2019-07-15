<?php

namespace Numbers\Application\MessageBus;

use Numbers\Application\Message;

interface PublisherInterface
{
    public function publish(Message $message): void;
}
