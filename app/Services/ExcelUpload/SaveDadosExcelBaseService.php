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
        $this->repository->deleteAll();

        $totalProdutosAdicionados = 0;
        foreach ($produtos as $index => $p) {
            $produto = [
                'id' => $index + 1,
                'produto' => $p['EMBALAGEM / PRODUTO'],
                'codigo' => (int) $p['CÓD.'],
                'custo' => (float) $p['CUSTO'],
                'fee_hke' => $p['FEE HKE'],
                'pis_cof' => (float) $p['PIS - COF'],
                'medio' => (float) $p['MÉDIO'],
                'qtde' => (int) $p['QTDE'],
                'total' => (int) $p['Y'],
                'preco' => (float) $p['PREÇO '],
                'qnt_x_custo' => (float) $p['QUANT * CUSTO'],
                'qnt_x_venda' => (float) $p['QUANT * V. VENDA'],
                'diferenca_reais' => (float) $p['DIFER. R$'],
                'markup' => (float) $p['MARKUP'],
            ];
            $this->repository->save($produto);
            $totalProdutosAdicionados++;
        }
        return $totalProdutosAdicionados;
    }
}
