<?php

namespace App\Repository\Produto;

interface ProdutoRepositoryInterface
{
    public function save(array $produtos): void;
    public function deleteAll(): void;
    public function removeIdRowsDeleted(): void;
    public function addIdRowsDeleted(): void;
    public function createBackupProdutos(): void;
}
