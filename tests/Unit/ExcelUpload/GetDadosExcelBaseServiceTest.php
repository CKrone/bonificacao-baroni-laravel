<?php

namespace ExcelUpload;

use App\Services\ExcelUpload\GetDadosExcelBaseService;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PHPUnit\Framework\TestCase;

class GetDadosExcelBaseServiceTest extends TestCase
{
    private GetDadosExcelBaseService $getDadosExcelBaseService;
    private string $fileDirectory;

    protected function setUp(): void
    {
        $this->getDadosExcelBaseService = new GetDadosExcelBaseService();
        parent::setUp();
    }

    protected function tearDown(): void
    {
        if (file_exists($this->fileDirectory)) {
            unlink($this->fileDirectory);
        }
        parent::tearDown();
    }

    private array $columns = [
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
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws Exception
     */
    public function testeShould(): void
    {
        $filePath = $this->mockExcelFile();
        $response = $this->getDadosExcelBaseService->execute($filePath);

        $this->assertIsArray($response->getDadosProdutos());
        $this->assertCount(1, $response->getDadosProdutos());
        $this->assertEquals('COCA COLA', $response->getDadosProdutos()[0]['EMBALAGEM / PRODUTO']);
    }

    /**
     * @throws Exception
     */
    private function mockExcelFile(): string
    {
        $values = $this->getMockValues();
        $this->fileDirectory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'example.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'IGNORAR');
        foreach (array_keys($this->columns) as $indexCol) {
            $sheet->setCellValue($indexCol . '1', 'IGNORAR');
        }

        foreach ($this->columns as $indexCol => $column) {
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
        $writer->save($this->fileDirectory);
        return $this->fileDirectory;
    }

    private function getMockValues(): array
    {
        $values = [];
        for ($i = 0; $i < 5; $i++) {
            $values[] = [
                'B' => 'COCA COLA',
                'C' => '123',
                'D' => '3.99',
                'E' => '4.50',
                'F' => '5.00',
                'G' => '2.50',
                'H' => '1',
                'I' => '2.00',
                'J' => '3.00',
                'K' => '4.00',
                'L' => '5.00',
                'M' => '6.00',
                'N' => '7.00',
            ];
        }
        return $values;
    }
}
