<?php

namespace Numbers\Application;

use Numbers\Domain\NumberValue;
use Numbers\Domain\SumCounterRepositoryInterface;

class SumCounterService
{
    /** @var SumCounterRepositoryInterface */
    private $repository;

    public function __construct(SumCounterRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function addNumber(string $sumCountId, string $numberValue): void
    {
        $number = new NumberValue($numberValue);
        $sumCount = $this->repository->sumCounterOfId($sumCountId);
        $sumCount->addNumber($number);
        $this->repository->save($sumCount);
    }
}
