<?php

use App\Http\Controllers\ImportacaoController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::post('/upload-excel-base', [ImportacaoController::class, 'uploadExcelBase']);
Route::post('/upload', [ImportacaoController::class, 'uploadRelatorio']);
Route::controller(ProdutoController::class)->group(function () {
    Route::get('/get-produtos-exportacao', 'getProdutosExportacao');
    Route::get('/get-ids-deleted', 'getIdRowsDeleted');
});
