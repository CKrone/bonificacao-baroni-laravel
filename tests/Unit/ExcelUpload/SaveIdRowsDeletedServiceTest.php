<?php

namespace ExcelUpload;

use App\Repository\RowDeleted\RowDeletedRepositoryInMemory;
use App\Services\ExcelUpload\SaveIdRowsDeletedService;
use PHPUnit\Framework\TestCase;

class SaveIdRowsDeletedServiceTest extends TestCase
{
    private SaveIdRowsDeletedService $saveIdRowsDeletedService;
    private RowDeletedRepositoryInMemory $repositoryInMemory;

    protected function setUp(): void
    {
        $this->repositoryInMemory = new RowDeletedRepositoryInMemory();
        $this->saveIdRowsDeletedService = new SaveIdRowsDeletedService($this->repositoryInMemory);
        parent::setUp();
    }

    public function testShouldDeleteAllIdRowsAndSaveNewIdRows(): void
    {
        $rowsDeleted = [5, 6, 7, 8];
        $rows = $this->repositoryInMemory->idRows;
        $this->assertNotEquals($rows, $rowsDeleted);

        $rowsDeletedService = $this->saveIdRowsDeletedService->execute($rowsDeleted);
        $this->assertSameSize($rowsDeleted, $rowsDeletedService);
        $this->assertEquals($rowsDeleted, $rowsDeletedService);
    }
}
