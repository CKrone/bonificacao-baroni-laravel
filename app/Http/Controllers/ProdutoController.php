<?php

namespace App\Http\Controllers;

use App\Services\RowsDeleted\GetIdRowsDeletedService;
use PhpOffice\PhpSpreadsheet\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function __construct(
        private GetIdRowsDeletedService $getIdRowsDeletedService,

    ) {
    }

    /**
     * @throws Exception
     */
    public function getProdutosExportacao(Request $request): JsonResponse
    {
        return response()->json(
            'dale'
        );
    }

    public function getIdRowsDeleted(): JsonResponse
    {
        return response()->json($this->getIdRowsDeletedService->execute());
    }
}
