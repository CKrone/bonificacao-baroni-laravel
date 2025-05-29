<?php

namespace ExcelUpload;

use App\Services\ExcelUpload\SaveDadosExcelBaseService;
use App\Repository\Produto\ProdutoRepositoryInMemory;
use PHPUnit\Framework\TestCase;

class SaveDadosExcelBaseServiceTest extends TestCase
{
    private SaveDadosExcelBaseService $saveDadosExcelBaseService;
    private ProdutoRepositoryInMemory $produtoRepositoryInMemory;
    protected function setUp(): void
    {
        $this->produtoRepositoryInMemory = new ProdutoRepositoryInMemory();
        $this->saveDadosExcelBaseService = new SaveDadosExcelBaseService($this->produtoRepositoryInMemory);
        parent::setUp();
    }

    public function testShouldMakeBackupAndClearProdutosAndAddNewProdutos(): void
    {
        $oldProdutos = $this->produtoRepositoryInMemory->produtos;
        $nomeProduto = $oldProdutos->toArray()[0]['produto'];
        $this->assertEquals('Kaiser', $nomeProduto);

        $mockProdutos = $this->getMockProdutos();
        $this->saveDadosExcelBaseService->execute($mockProdutos);

        $produtosBackup = $this->produtoRepositoryInMemory->produtosBackup;
        $nomeProdutoBackup = $produtosBackup->toArray()[0]['produto'];
        $this->assertEquals('Kaiser', $nomeProdutoBackup);

        $newProdutos = $this->produtoRepositoryInMemory->produtos;
        $nomeProduto = $newProdutos->toArray()[0]['produto'];
        $this->assertEquals('COCA COLA', $nomeProduto);
    }

    private function getMockProdutos(): array
    {
        $produtos[] = [
            'EMBALAGEM / PRODUTO' => 'COCA COLA',
            'CÓD.' => '123',
            'CUSTO' => '3.99',
            'FEE HKE' => '4.5',
            'PIS - COF' => '5',
            'MÉDIO' => '2.5',
            'QTDE' => '1',
            'Y' => '2',
            'PREÇO ' => '3',
            'QUANT * CUSTO' => '4',
            'QUANT * V. VENDA' => '5',
            'DIFER. R$' => '6',
            'MARKUP' => '7',
        ];
        return $produtos;
    }
}
