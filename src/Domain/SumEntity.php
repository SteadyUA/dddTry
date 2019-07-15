<?php

namespace Numbers\Domain;

class SumEntity
{
    private $id;

    /** @var NumberValue */
    private $amount;

    public function __construct(string $id, NumberValue $numberValue)
    {
        $this->id = $id;
        $this->amount = $numberValue;
    }

    public function add(NumberValue $numberValue)
    {
        $this->amount = $this->amount->add($numberValue);
    }

    public function amount(): NumberValue
    {
        return $this->amount;
    }

    public function id(): string
    {
        return $this->id;
    }
}
