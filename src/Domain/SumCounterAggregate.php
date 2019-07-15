<?php

namespace Numbers\Domain;

class SumCounterAggregate
{
    private $sum;
    private $counter;

    public function __construct(SumEntity $sum, CounterEntity $counter)
    {
        $this->sum = $sum;
        $this->counter = $counter;
    }

    public function addNumber(NumberValue $number)
    {
        $this->sum->add($number);
        $this->counter->increment();
    }

    public function id(): string
    {   // composite key
        return "{$this->sum->id()}-{$this->counter->id()}";
    }

    public function sum(): SumEntity
    {
        return $this->sum;
    }

    public function counter(): CounterEntity
    {
        return $this->counter;
    }
}
