<?php

namespace App\Http\Controllers;

use App\Services\ExcelUpload\GetDadosExcelBaseService;
use PhpOffice\PhpSpreadsheet\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImportacaoController extends Controller
{
    public function __construct(
        private GetDadosExcelBaseService $getDadosExcelBaseService
    ) {
    }

    /**
     * @throws Exception
     */
    public function uploadExcelBase(Request $request): JsonResponse
    {
        $fileExcel = $request->file('file');
        if (! $fileExcel) {
            return response()->json([
                'message' => 'Por favor, adicione um arquivo no formato .xlsx'
            ], 400);
        }

        if ($fileExcel->getClientOriginalExtension() !== 'xlsx') {
            return response()->json([
                'message' => 'Arquivo com formato inválido, formato aceito .xlsx'
            ], 400);
        }

        return response()->json(
            $this->getDadosExcelBaseService->execute($fileExcel->getPathname())
        );
    }
}
