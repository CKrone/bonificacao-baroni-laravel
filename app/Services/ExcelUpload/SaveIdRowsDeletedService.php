<?php

namespace App\Services\ExcelUpload;

use App\Repository\RowDeleted\RowDeletedRepositoryInterface;

class SaveIdRowsDeletedService
{
    public function __construct(
        private RowDeletedRepositoryInterface $repository,
    ) {
    }

    public function execute(array $idRowsDeleted): array
    {
        $this->repository->deleteAll();
        foreach ($idRowsDeleted as $idRow) {
            $this->repository->save($idRow);
        }
        return $this->repository->findAll();
    }
}
