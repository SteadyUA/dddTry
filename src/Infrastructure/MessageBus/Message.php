<?php

namespace Numbers\Infrastructure\MessageBus;

class Message
{
    private $number;
    private $id;

    private static $index = 0;

    public function __construct(string $number, int $id)
    {
        $this->number = $number;
        $this->id = $id;
    }

    public function number(): string
    {
        return $this->number;
    }

    public function id(): int
    {
        return $this->id;
    }

    public static function create(string $number): Message
    {
        return new Message($number, self::nextIdentity());
    }

    private static function nextIdentity(): int
    {
        return self::$index ++;
    }
}
