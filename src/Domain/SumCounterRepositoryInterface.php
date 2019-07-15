<?php

namespace Numbers\Domain;

interface SumCounterRepositoryInterface
{
    public function save(SumCounterAggregate $aggregate): void;
    public function sumCounterOf(string $id): SumCounterAggregate;
}
