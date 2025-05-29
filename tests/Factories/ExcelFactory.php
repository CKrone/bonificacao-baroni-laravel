<?php

namespace Tests\Factories;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelFactory
{
    private const COLUMNS = [
        'B' => 'EMBALAGEM / PRODUTO',
        'C' => 'CÓD.',
        'D' => 'CUSTO',
        'E' => 'FEE HKE',
        'F' => 'PIS - COF',
        'G' => 'MÉDIO',
        'H' => 'QTDE',
        'I' => 'Y',
        'J' => 'PREÇO ',
        'K' => 'QUANT * CUSTO',
        'L' => 'QUANT * V. VENDA',
        'M' => 'DIFER. R$',
        'N' => 'MARKUP',
    ];

    /**
     * @throws Exception
     */
    public static function createExampleExcel(array $values): string
    {
        $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'example.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'IGNORAR');
        foreach (array_keys(self::COLUMNS) as $indexCol) {
            $sheet->setCellValue($indexCol . '1', 'IGNORAR');
        }

        foreach (self::COLUMNS as $indexCol => $column) {
            $sheet->setCellValue($indexCol . '2', $column);
        }

        $rowId = 3;
        foreach ($values as $value) {
            foreach ($value as $cellCol => $val) {
                $sheet->setCellValue($cellCol . $rowId, $val);
            }
            $rowId++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
        return $filePath;
    }
}
