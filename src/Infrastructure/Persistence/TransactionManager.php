<?php

namespace Numbers\Infrastructure\Persistence;

class TransactionManager
{
    /** @var PersistenceInterface[] */
    private $persistence = [];

    public function register(PersistenceInterface $persistence): void
    {
        $this->persistence[] = $persistence;
    }

    public function beginTransaction(): void
    {
        foreach ($this->persistence as $persistence) {
            $persistence->beginTransaction();
        }
    }

    public function commitTransaction(): void
    {
        foreach ($this->persistence as $persistence) {
            $persistence->commitTransaction();
        }
    }

    public function rollbackTransaction(): void
    {
        foreach ($this->persistence as $persistence) {
            $persistence->rollbackTransaction();
        }
    }
}
