<?php

namespace App\Services\PDFUpload;

use Exception;

class GetDadosRelatorioPDFService
{
    /**
     * @throws Exception
     */
    public function execute(string $filePath): array
    {
        $arquivoPdf = new ArquivoPDF($filePath);
        return $arquivoPdf->getArrayDados();
    }
}
