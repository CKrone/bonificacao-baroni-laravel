<?php

namespace App\Services\Bonificacao;

use App\Services\Bonificacao\InputOutputdata\BonificacaoOutputData;

class GetBonificacaoRelatorioService
{
    private const VALOR_PADRAO_PRECO_MEDIO = 0.00;
    public function execute(array $produtos): array
    {
        return $this->getArrayBonificacao($produtos);
    }

    private function getArrayBonificacao(array $relatorio): array
    {
        $arrayBonificacao = [];
        foreach ($relatorio as $item) {
            $arrBonificacao = [
                'codigo' => (int) $item['CODIGO'],
                'produto' => $item['PRODUTO'],
                'bonificacao' => (int) $item['BONIF'],
                'vendas' => $this->extrairNumero($item['VENDAS']),
                'precoMedio' => $this->calculaNovoPrecoMedio($item),
                'qntFinal' => $this->somaBonificacaoComVendas($item),
            ];
            $bonificacao = BonificacaoOutputData::createWithValues($arrBonificacao);
            $arrayBonificacao[] = $bonificacao->toArray();
        }
        return $arrayBonificacao;
    }

    private function somaBonificacaoComVendas(array $item): float
    {
        return (int) $item['BONIF'] + $this->extrairNumero($item['VENDAS']);
    }

    private function calculaNovoPrecoMedio(array $item): float
    {
        $qntFinal = $this->somaBonificacaoComVendas($item);
        $valorVenda = (float)str_replace(',', '.', $item['VLR.VENDA']);

        if ($item['CODIGO'] === '0') {
            return 0;
        }

        if ($qntFinal > 0) {
            return $valorVenda / $qntFinal;
        }
        return self::VALOR_PADRAO_PRECO_MEDIO;
    }

    private function extrairNumero(string $valor): float
    {
        $valorLimpo = preg_replace('/[^0-9.]/', '', $valor);
        return (float) $valorLimpo;
    }
}
