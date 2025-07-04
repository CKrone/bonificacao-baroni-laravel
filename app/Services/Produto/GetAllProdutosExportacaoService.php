<?php

namespace App\Services\Produto;

use App\Repository\Produto\ProdutoRepositoryInterface;

class GetAllProdutosExportacaoService
{
    public function __construct(
        private ProdutoRepositoryInterface $produtoRepository,
    ) {
    }

    public function execute(): void
    {

    }
}
