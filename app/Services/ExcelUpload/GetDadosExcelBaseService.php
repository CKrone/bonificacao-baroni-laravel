<?php

namespace App\Services\ExcelUpload;

use App\Services\ExcelUpload\InputOuputdata\DadosExcelBaseOutput;
use PhpOffice\PhpSpreadsheet\Exception;

class GetDadosExcelBaseService
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(string $filePath): DadosExcelBaseOutput
    {
        $excel = new ArquivoExcelBase($filePath);
        $excel->definirColunas('EMBALAGEM / PRODUTO', 'EMBALAGEM / PRODUTO');
        $excel->definirColunas('CÓD.', 'CÓD.');
        $excel->definirColunas('CUSTO', 'CUSTO');
        $excel->definirColunas('FEE HKE', 'FEE HKE');
        $excel->definirColunas('PIS - COF', 'PIS - COF');
        $excel->definirColunas('MÉDIO', 'MÉDIO');
        $excel->definirColunas('QTDE', 'QTDE');
        $excel->definirColunas('Y', 'Y');
        $excel->definirColunas('PREÇO ', 'PREÇO ');
        $excel->definirColunas('QUANT * CUSTO', 'QUANT * CUSTO');
        $excel->definirColunas('QUANT * V. VENDA', 'QUANT * V. VENDA');
        $excel->definirColunas('DIFER. R$', 'DIFER. R$');
        $excel->definirColunas('MARKUP', 'MARKUP');

        return new DadosExcelBaseOutput(
            $excel->getArrayDados(),
            $excel->getIdRowsDeleted(),
        );
    }
}
