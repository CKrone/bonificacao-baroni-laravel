<?php

namespace App\Services\RowsDeleted;

use App\Repository\RowDeleted\RowDeletedRepositoryInterface;

class GetIdRowsDeletedService
{
    public function __construct(
        private RowDeletedRepositoryInterface $rowDeletedRepository
    ) {
    }

    public function execute(): array
    {
        return $this->rowDeletedRepository->findAll();
    }
}
