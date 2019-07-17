<?php

namespace Numbers\Domain;

interface SumCounterRepositoryInterface
{
    public function save(SumCounterAggregate $sumCounter): void;
    public function sumCounterOfId(string $sumCountId): SumCounterAggregate;
}
