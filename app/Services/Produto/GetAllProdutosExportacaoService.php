<?php

namespace App\Services\Produto;

use App\Repository\Produto\ProdutoRepositoryInterface;
use App\Services\RowsDeleted\GetIdRowsDeletedService;

class GetAllProdutosExportacaoService
{
    public function __construct(
        private ProdutoRepositoryInterface $produtoRepository,
        private GetIdRowsDeletedService $getIdRowsDeletedService,
    ) {
    }

    public function execute(): array
    {
        $allProdutos = $this->produtoRepository->findAll();
        $idRows = $this->getIdRowsDeletedService->execute();

        return $this->addEmptyRows($allProdutos, $idRows);
    }

    private function addEmptyRows(array $produtos, array $idRows): array
    {
        $rowsToAdd = [];
        foreach ($produtos as $index => $produto) {
            foreach ($idRows as $row) {
                if ((int) $index === $row - 1) {
                    $rowsToAdd[$index] = [
                        'id' => '',
                        'produto' => '',
                        'codigo' => '',
                        'qtde' => '',
                        'preco' => '',
                    ];
                }
            }
        }

        foreach ($rowsToAdd as $indice => $item) {
            $positionToAdd = $indice;
            array_splice($produtos, $positionToAdd, 0, [$item]);
        }
        return $produtos;
    }
}
