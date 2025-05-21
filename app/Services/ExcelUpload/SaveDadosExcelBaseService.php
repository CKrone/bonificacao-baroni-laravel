<?php

namespace App\Services\ExcelUpload;

use App\Repository\Produto\ProdutoRepositoryInterface;

class SaveDadosExcelBaseService
{
    public function __construct(
        private ProdutoRepositoryInterface $repository
    ) {
    }
    public function execute(array $produtos): int
    {
        $this->repository->createBackup();
        $this->repository->deleteAll();

        $totalProdutosAdicionados = 0;
        foreach ($produtos as $index => $p) {
            $produto = $this->buildArrayProduto($index, $p);
            $this->repository->save($produto);
            $totalProdutosAdicionados++;
        }
        return $totalProdutosAdicionados;
    }

    private function buildArrayProduto(int $index, array $produto): array
    {
        return [
            'id' => $index + 1,
            'produto' => $produto['EMBALAGEM / PRODUTO'],
            'codigo' => (int) $produto['CÓD.'],
            'custo' => (float) $produto['CUSTO'],
            'fee_hke' => $produto['FEE HKE'],
            'pis_cof' => (float) $produto['PIS - COF'],
            'medio' => (float) $produto['MÉDIO'],
            'qtde' => (int) $produto['QTDE'],
            'total' => (int) $produto['Y'],
            'preco' => (float) $produto['PREÇO '],
            'qnt_x_custo' => (float) $produto['QUANT * CUSTO'],
            'qnt_x_venda' => (float) $produto['QUANT * V. VENDA'],
            'diferenca_reais' => (float) $produto['DIFER. R$'],
            'markup' => (float) $produto['MARKUP'],
        ];
    }
}
