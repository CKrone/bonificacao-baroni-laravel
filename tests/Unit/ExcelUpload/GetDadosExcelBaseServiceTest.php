<?php

namespace ExcelUpload;

use App\Services\ExcelUpload\GetDadosExcelBaseService;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Tests\Factories\ExcelFactory;
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

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws Exception
     */
    public function testeShouldReturnRegistersFromExcel(): void
    {
        $this->fileDirectory = ExcelFactory::createExampleExcel($this->getMockValues());
        $response = $this->getDadosExcelBaseService->execute($this->fileDirectory);

        $this->assertIsArray($response->getDadosProdutos());
        $this->assertCount(1, $response->getDadosProdutos());
        $this->assertEquals('COCA COLA', $response->getDadosProdutos()[0]['EMBALAGEM / PRODUTO']);
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws Exception
     */
    public function testeShouldReturnRegistersFromExcelAndIdRowsToDelete(): void
    {
        $this->fileDirectory = ExcelFactory::createExampleExcel(array_merge($this->addRowsToDelete(), $this->getMockValues()));
        $response = $this->getDadosExcelBaseService->execute($this->fileDirectory);

        $this->assertIsArray($response->getDadosProdutos());
        $this->assertCount(1, $response->getDadosProdutos());
        $this->assertCount(2, $response->getIdRowsDeleted());
        $this->assertEquals(1, $response->getIdRowsDeleted()[0]);
        $this->assertEquals(2, $response->getIdRowsDeleted()[1]);
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

    private function addRowsToDelete(): array
    {
        $values = [];
        $values[] = [
            'B' => 'VALORES CATEGORIA',
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
        $values[] = [
            'B' => 'MARKUP CATEGORIA',
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
        return $values;
    }
}
