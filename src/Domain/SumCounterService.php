<?php

namespace Numbers\Domain;

class SumCounterService
{
    /** @var SumCounterRepositoryInterface */
    private $repository;

    public function __construct(SumCounterRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function addNumber(string $sumCountId, NumberValue $numberValue)
    {
        $sumCount = $this->repository->sumCounterOf($sumCountId);

        $sumCount->addNumber($numberValue);

        $this->repository->save($sumCount);
    }
}
