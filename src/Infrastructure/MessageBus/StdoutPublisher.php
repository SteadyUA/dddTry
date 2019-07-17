<?php

namespace Numbers\Infrastructure\MessageBus;

use RuntimeException;

/**
 * For tests in cli pipeline call
 */
class StdoutPublisher implements PublisherInterface
{
    private $stream;

    public function __construct()
    {
        $this->stream = STDOUT;
    }

    public function publish(Message $message): void
    {
        $messageString = "{$message->id()}\t{$message->number()}\n";
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
