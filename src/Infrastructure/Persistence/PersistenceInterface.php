<?php

namespace Numbers\Infrastructure\Persistence;

interface PersistenceInterface
{
    public function persist(array $data): void;
    public function restore(): array;
    public function beginTransaction(): void;
    public function commitTransaction(): void;
    public function rollbackTransaction(): void;
}
