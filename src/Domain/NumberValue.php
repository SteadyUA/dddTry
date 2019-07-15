<?php

namespace Numbers\Domain;

use InvalidArgumentException;

class NumberValue
{
    private $value;

    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function add(NumberValue $number): NumberValue
    {
        return new static(bcadd($this->value, $number->value));
    }

    public function equals(NumberValue $number): bool
    {
        return $this->value == $number->value;
    }

    public function compareTo(NumberValue $number): int
    {
        return bccomp($this->value, $number->value);
    }

    private function setValue($value)
    {
        if (false == ctype_digit($value)) {
            throw new InvalidArgumentException('Not decimal number passed.');
        }
        $this->value = $value;
    }
}
