<?php

namespace App\Repository\Produto;

use Illuminate\Support\Facades\{Schema, DB};
use App\Models\Produto;

class ProdutoRepositoryDatabase implements ProdutoRepositoryInterface
{
    public function save(array $produtos): void
    {
        Produto::insert($produtos);
    }

    public function deleteAll(): void
    {
        Produto::query()->delete();
    }

    public function createBackup(): void
    {
        $tableBackup = 'backup_produto';
        $tableProduto = 'produto';

        if (Schema::hasTable($tableBackup)) {
            Schema::drop($tableBackup);
        }

        DB::statement("CREATE TABLE {$tableBackup} LIKE {$tableProduto}");
        DB::statement("INSERT INTO {$tableBackup} SELECT * FROM {$tableProduto}");
    }

    public function removeIdRowsDeleted(): void
    {
        // TODO: Implement removeIdRowsDeleted() method.
    }

    public function addIdRowsDeleted(): void
    {
        // TODO: Implement addIdRowsDeleted() method.
    }
}
