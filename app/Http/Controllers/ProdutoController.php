<?php

namespace App\Http\Controllers;

use App\Services\Produto\GetAllProdutosExportacaoService;
use App\Services\RowsDeleted\GetIdRowsDeletedService;
use PhpOffice\PhpSpreadsheet\Exception;
use Illuminate\Http\JsonResponse;

class ProdutoController extends Controller
{
    public function __construct(
        private GetAllProdutosExportacaoService $produtosExportacaoService,
        private GetIdRowsDeletedService $getIdRowsDeletedService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function getProdutosExportacao(): JsonResponse
    {
        return response()->json($this->produtosExportacaoService->execute());
    }

    public function getIdRowsDeleted(): JsonResponse
    {
        return response()->json($this->getIdRowsDeletedService->execute());
    }
}
