<?php

namespace App\Repository\Produto;

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
        // TODO: Implement createBackupProdutos() method.
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
