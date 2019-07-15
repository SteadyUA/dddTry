<?php

namespace Numbers\Application\MessageBus;

use Numbers\Application\Message;
use Numbers\Domain\NumberValue;
use RuntimeException;

/**
 * For tests in cli pipe call
 */
class StreamConsumer implements ConsumerInterface
{
    private $messageString = '';
    private $hasMessage = false;
    private $stream;

    public function __construct($stream)
    {
        stream_set_blocking($stream, false);
        $this->stream = $stream;
    }

    public function pull(): ?Message
    {
        $this->readStream();
        if (false == $this->hasMessage) {
            return null;
        }
        list($id, $number) = explode("\t", $this->messageString);
        $message = new Message(new NumberValue($number), $id);

        return $message;
    }

    public function ack(): void
    {
        $this->hasMessage = false;
        $this->messageString = '';
    }

    private function readStream()
    {
        if ($this->hasMessage) {
            return;
        }
        while (feof($this->stream) == false) {
            $c = fread($this->stream, 1);
            if (false === $c) {
                throw new RuntimeException('Error on stream read.');
            }
            if ("\n" === $c) {
                if (strlen($this->messageString) > 0) {
                    $this->hasMessage = true;
                    break;
                }
            }
            $this->messageString .= $c;
        }
    }
}
