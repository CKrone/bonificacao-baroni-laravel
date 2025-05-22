<?php

namespace App\Repository\RowDeleted;

interface RowDeletedRepositoryInterface
{
    public function save(int $idRow): void;
    public function deleteAll(): void;
    public function findAll(): array;
}
