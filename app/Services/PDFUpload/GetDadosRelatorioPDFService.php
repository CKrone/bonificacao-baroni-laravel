<?php

namespace App\Services\PDFUpload;

class GetDadosRelatorioPDFService
{
    public function execute(string $filePath): array
    {
        $arquivoPdf = new ArquivoPDF($filePath);
        return $arquivoPdf->getArrayDados();
    }
}
