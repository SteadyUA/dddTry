<?php

namespace Numbers\Application\Persistence;

/**
 * for debug and tests
 */
class InMemoryPersistence implements PersistenceInterface
{
    private $data = [
        'sum' => '0',
        'count_fib' => '0',
        'count_prime' => '0'
    ];

    private $debug = false;
    private $dataToCommit;

    public function __construct($debug = false)
    {
        $this->debug = $debug;
    }

    public function persist(array $data): void
    {
        $this->dataToCommit = $data;
    }

    public function restore(): array
    {
        return $this->data;
    }

    public function beginTransaction(): void
    {
        // empty
    }

    public function commitTransaction(): void
    {
        if ($this->debug) {
            foreach ($this->dataToCommit as $field => $value) {
                echo "{$field}: $value\t";
            }
            echo "\n";
        }
        $this->data = array_merge($this->data, $this->dataToCommit);
    }

    public function rollbackTransaction(): void
    {
        $this->dataToCommit = [];
    }
}
