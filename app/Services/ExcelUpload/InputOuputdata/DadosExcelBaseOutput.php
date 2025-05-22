<?php

namespace App\Services\ExcelUpload\InputOuputdata;

class DadosExcelBaseOutput
{
    public function __construct(
        public array $dadosProdutos,
        public array $idRowsDeleted,
    ) {
    }

    public function getDadosProdutos(): array
    {
        return $this->dadosProdutos;
    }

    public function getIdRowsDeleted(): array
    {
        return $this->idRowsDeleted;
    }
}
