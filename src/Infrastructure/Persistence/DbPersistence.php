<?php

namespace Numbers\Infrastructure\Persistence;

use PDO;
use RuntimeException;

class DbPersistence implements PersistenceInterface
{
    /** @var PDO */
    private $dbh;
    private $tableName;

    public function __construct(PDO $dbh, string $tableName)
    {
        $this->dbh = $dbh;
        $this->tableName = $tableName;
    }

    public function persist(array $data): void
    {
        $fields = ['sum', 'count_fib', 'count_prime'];
        $updateField = [];
        $params = [];
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $updateField[] = "`{$field}` = :{$field}";
                $params[":{$field}"] = $data[$field];
            }
        }
        if (empty($params)) {
            throw new RuntimeException('Data does not contain known fields.');
        }
        $this->dbh
            ->prepare("UPDATE {$this->tableName} SET " . implode(', ', $updateField))
            ->execute($params);
    }

    public function restore(): array
    {
        $sth = $this->dbh->query("SELECT * FROM {$this->tableName} FOR UPDATE");
        $row = $sth->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function beginTransaction(): void
    {
        $this->dbh->beginTransaction();
    }

    public function commitTransaction(): void
    {
        $this->dbh->commit();
    }

    public function rollbackTransaction(): void
    {
        $this->dbh->rollBack();
    }
}
