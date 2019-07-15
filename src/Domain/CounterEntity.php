<?php

namespace Numbers\Domain;

class CounterEntity
{
    private $id;
    private $amount = 0;

    public function __construct(string $id, int $amount)
    {
        $this->id = $id;
        $this->amount = $amount;
    }

    public function increment()
    {
        $this->amount ++;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function id()
    {
        return $this->id;
    }
}
