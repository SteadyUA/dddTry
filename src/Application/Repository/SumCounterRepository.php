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

    public function save(SumCounterAggregate $aggregate): void
    {
        $data = [
            $aggregate->sum()->id() => $aggregate->sum()->amount()->toString(),
            $aggregate->counter()->id() => $aggregate->counter()->amount()
        ];
        $this->storage->persist($data);
    }

    public function sumCounterOf(string $id): SumCounterAggregate
    {
        list($sumId, $counterId) = explode('-', $id);

        $data = $this->storage->restore();
        $sumAmount = $data[$sumId];
        $counterAmount = $data[$counterId];

        return new SumCounterAggregate(
            new SumEntity($sumId, new NumberValue($sumAmount)),
            new CounterEntity($counterId, $counterAmount)
        );
    }
}
