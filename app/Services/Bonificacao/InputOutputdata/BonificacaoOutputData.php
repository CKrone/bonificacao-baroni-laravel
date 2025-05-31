<?php

namespace App\Services\Bonificacao\InputOutputdata;

use App\Contracts\FillValuesOnCreationInterface;

class BonificacaoOutputData implements FillValuesOnCreationInterface, \JsonSerializable
{
    public function __construct(
        private int $codigo,
        private string $produto,
        private int $bonif,
        private int $vendas,
        private float $pMedio,
        private float $qntFinal,
    ) {
    }

    public static function createWithValues($data): BonificacaoOutputData
    {
       return new self(
           $data['codigo'],
           $data['produto'],
           $data['bonificacao'],
           $data['vendas'],
           $data['precoMedio'],
           $data['qntFinal'],
       );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
