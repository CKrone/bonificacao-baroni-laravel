<?php

use App\Http\Controllers\ImportacaoController;
use Illuminate\Support\Facades\Route;

Route::post('/upload-excel-base', [ImportacaoController::class, 'uploadExcelBase']);
Route::post('/upload-relatorio', [ImportacaoController::class, 'uploadRelatorio']);
