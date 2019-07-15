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

    public function increment(): void
    {
        $this->amount ++;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function id(): string
    {
        return $this->id;
    }
}
