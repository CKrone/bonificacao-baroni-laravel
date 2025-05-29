<?php

namespace App\Repository\RowDeleted;

use Illuminate\Database\Eloquent\Collection;

class RowDeletedRepositoryInMemory implements RowDeletedRepositoryInterface
{
    public Collection $idRows;

    public function __construct()
    {
        $this->idRows = new Collection();
        $rows = [10, 11, 12, 13];
        $this->idRows->add($rows);
    }

    public function save(int $idRow): void
    {
        $this->idRows->add($idRow);
    }

    public function deleteAll(): void
    {
        $this->idRows = new Collection();
    }

    public function findAll(): array
    {
        return $this->idRows->toArray();
    }
}
