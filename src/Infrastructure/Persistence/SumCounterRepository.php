<?php

namespace Numbers\Application\Repository;

use Numbers\Application\Persistence\PersistenceInterface;
use Numbers\Domain\CounterEntity;
use Numbers\Domain\NumberValue;
use Numbers\Domain\SumCounterAggregate;
use Numbers\Domain\SumCounterRepositoryInterface;
use Numbers\Domain\SumEntity;

class SumCounterRepository implements SumCounterRepositoryInterface
{
    private $storage;

    public function __construct(PersistenceInterface $storage)
    {
        $this->storage = $storage;
    }

    public function save(SumCounterAggregate $sumCounter): void
    {
        $data = [
            $sumCounter->sum()->id() => $sumCounter->sum()->amount()->toString(),
            $sumCounter->counter()->id() => $sumCounter->counter()->amount()
        ];
        $this->storage->persist($data);
    }

    public function sumCounterOf(string $sumCountId): SumCounterAggregate
    {
        // parse composite key
        list($sumId, $counterId) = explode('-', $sumCountId);

        $data = $this->storage->restore();
        $sumAmount = $data[$sumId];
        $counterAmount = $data[$counterId];

        return new SumCounterAggregate(
            new SumEntity($sumId, new NumberValue($sumAmount)),
            new CounterEntity($counterId, $counterAmount)
        );
    }
}
