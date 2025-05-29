<?php

namespace App\Repository\Produto;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Collection;

class ProdutoRepositoryInMemory implements ProdutoRepositoryInterface
{
    public Collection $produtos;
    public Collection $produtosBackup;

    public function __construct()
    {
        $this->produtos = new Collection();
        $produtosBase = new Produto();
        $produtosBase->id = 1;
        $produtosBase->produto = 'Kaiser';
        $produtosBase->codigo = '99';
        $produtosBase->custo = '15.99';
        $produtosBase->fee_hke = '20.00';
        $produtosBase->pis_cof = '25.00';
        $produtosBase->medio = '22.50';
        $produtosBase->qtde = '5';
        $produtosBase->preco = '23.50';
        $produtosBase->total = '27.50';
        $produtosBase->qnt_x_custo = '10.50';
        $produtosBase->qbt_x_venda = '12.50';
        $produtosBase->diferenca_reais = '14.20';
        $produtosBase->markup = '16.49';
        $this->produtos->add($produtosBase);
        $this->produtosBackup = new Collection();
    }

    public function save(array $produtos): void
    {
        $this->produtos->add($produtos);
    }

    public function deleteAll(): void
    {
        $this->produtos = new Collection();
    }

    public function createBackup(): void
    {
        $this->produtosBackup = $this->produtos;
    }
}
