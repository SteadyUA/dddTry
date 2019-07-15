<?php

namespace Numbers\Application;

use Numbers\Domain\NumberValue;

class Message
{
    private $number;
    private $id;

    private static $index = 0;

    public function __construct(NumberValue $number, int $id)
    {
        $this->number = $number;
        $this->id = $id;
    }

    public function number(): NumberValue
    {
        return $this->number;
    }

    public function id(): int
    {
        return $this->id;
    }

    public static function generateNextId(): int
    {
        return self::$index ++;
    }
}
