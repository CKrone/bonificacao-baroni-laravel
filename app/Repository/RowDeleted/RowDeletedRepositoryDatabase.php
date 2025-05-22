<?php

namespace App\Repository\RowDeleted;

use App\Models\RowDeleted;

class RowDeletedRepositoryDatabase implements RowDeletedRepositoryInterface
{
    public function save(int $idRow): void
    {
        RowDeleted::insert([
            'id_row' => $idRow,
        ]);
    }
    public function deleteAll(): void
    {
        RowDeleted::query()->delete();
    }

    public function findAll(): array
    {
        return RowDeleted::pluck('id_row')->toArray();
    }
}
