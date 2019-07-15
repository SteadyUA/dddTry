<?php

namespace Numbers\Application\MessageBus;

use Numbers\Application\Message;
use RuntimeException;

/**
 * For tests in cli pipe call
 */
class StreamPublisher implements PublisherInterface
{
    private $stream;

    public function __construct($stream)
    {
        $this->stream = $stream;
    }

    public function publish(Message $message): void
    {
        $messageString = "{$message->id()}\t{$message->number()->toString()}\n";
        $this->write($messageString);
    }

    private function write(string $string)
    {
        for ($written = 0; $written < strlen($string); $written += $result) {
            $result = fwrite($this->stream, substr($string, $written));
            if (false === $result) {
                throw new RuntimeException('Error on write.');
            }
            if (0 === $result) {
                // pipe closed
                exit(1);
            }
        }
    }
}
