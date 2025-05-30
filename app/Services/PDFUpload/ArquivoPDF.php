<?php

namespace App\Services\PDFUpload;

use Smalot\PdfParser\Parser;

class ArquivoPDF
{
    /**
     * @var Parser
     */
    protected $parser;

    protected $pdf;
    protected $arquivoPath;

    protected $colunas = [];
    protected $dados = [];

    protected const QNT_COLUNAS_SO_BONIFICADO_MEIA_CX = 3;
    protected const QNT_COLUNAS_SO_BONIFICADO_OU_VENDIDO_MEIA_CX = 4;
    protected const QNT_COLUNAS_BONIFICADO_E_VENDIDO_MEIA_CX = 5;

    protected const INDEX_BONIFICACAO = 9;
    protected const INDEX_COLUNA_VENDAS = 4;

    /**
     * @throws \Exception
     */
    public function __construct($arquivoPath)
    {
        $this->arquivoPath = $arquivoPath;
        $this->parser = new Parser();
        $this->pdf = $this->parser->parseFile($this->arquivoPath);
    }

    public function getArrayDados(): array
    {
        $pdfText = $this->getTextFromPDF();

        $quebrarLinhas = $this->getLinhas($pdfText);

        $dados = $this->getDados($quebrarLinhas);

        $semCabecalho = $this->removeCabecalhoPDF($dados);

        $colunas = $this->getColunas($semCabecalho);

        array_shift($this->dados);

        $getDados = $this->getValues($this->dados);

        return $this->montarValoresPorColuna($colunas, $getDados);
    }

    public function getTextFromPDF(): string
    {
        return $this->pdf->getText();
    }

    private function getValues(array $dados): array
    {
        foreach ($dados as &$item) {
            $indiceCX = $this->encontrarUltimoIndiceCX($item);

            if ($indiceCX) {
                $nonoIndice = $indiceCX + 9;
                $oitavoindice = $indiceCX + 8;
                $setimoIndice = $indiceCX + 7;

                if ($item[$indiceCX + 6] != '') {
                    $nonoIndice = $indiceCX + 6 + self::INDEX_BONIFICACAO;
                    if ($item[$nonoIndice] == '' && $item[$nonoIndice + 1] != '') {
                        $nonoIndice += 1;
                    }

                    if ($item[$nonoIndice] == '' && $item[$nonoIndice - 1] != '') {
                        $nonoIndice -= 1;
                    }
                }

                if (empty($item[$setimoIndice]) && empty($item[$oitavoindice]) && empty($item[$nonoIndice])) {
                    $item[$nonoIndice] = "0";

                    $indiceDevolucao = $nonoIndice + self::INDEX_BONIFICACAO;

                    for ($i = $indiceDevolucao; $i <= $indiceDevolucao + self::INDEX_BONIFICACAO; $i++) {
                        if (isset($item[$i]) && empty($item[$i]) && empty($item[$i + 1]) && empty($item[$i + 2]) && empty($item[$i - 1])) {
                            $item[$i] = "0";
                            break;
                        }
                        break;
                    }
                }

                if (! $this->hasCorrectItems($item)) {
                    if (! empty($item[$nonoIndice])) {
                        $item = $this->ajustaDadosColunas($item, $nonoIndice);
                    }

                    if (! empty($item[$oitavoindice])) {
                        $item = $this->ajustaDadosColunas($item, $oitavoindice);
                    }

                    if (! empty($item[$setimoIndice])) {
                        $item = $this->ajustaDadosColunas($item, $setimoIndice);
                    }
                }

                $item = array_filter($item, function ($valor) {
                    return $valor !== "";
                });

                $item = array_values($item);
            }
        }

        return $this->concatenarAteCX($dados);
    }

    private function hasCorrectItems(array $item): bool
    {
        $validCount = 0;
        foreach ($item as $indice => $valor) {
            if ($valor === 'CX') {
                foreach (array_slice($item, $indice + 1) as $restanteValor) {
                    if (str_contains($restanteValor, ',')) {
                        break;
                    }

                    if (! empty($restanteValor)) {
                        $validCount++;
                    }

                    if ($validCount >= 3) {
                        return true;
                    }
                }
                return false;
            }

        }
        return false;
    }

    private function encontrarUltimoIndiceCX(array $item): int
    {
        $ultimoIndiceCX = -1;

        foreach ($item as $indice => $valor) {
            if ($valor === "CX" || $valor === "UN") {
                $ultimoIndiceCX = $indice;
            }
        }
        return $ultimoIndiceCX;
    }

    private function ajustaDadosColunas(array $item, int $index): array
    {
        $indiceDevolucao = $index + self::INDEX_BONIFICACAO;

        for ($i = $indiceDevolucao; $i <= $indiceDevolucao + self::INDEX_BONIFICACAO; $i++) {
            if (isset($item[$i]) && empty($item[$i])) {
                if (! empty($item[$i + 1]) || ! empty($item[$i - 1])) {
                    break;
                }
                $item[$i] = "0";
                break;
            }
            break;
        }
        return $item;
    }

    private function concatenarAteCX(array $dados): array
    {
        foreach ($dados as &$item) {
            $indiceCX = $this->encontrarUltimoIndiceCX($item);

            if ($indiceCX) {
                $concatenado = implode(" ", array_slice($item, 1, $indiceCX));
                $item = array_merge(
                    array_slice($item, 0, 1),
                    [$concatenado],
                    array_slice($item, $indiceCX + 1)
                );
            }
        }

        return $dados;
    }

    public function montarValoresPorColuna(array $colunas, array $dados): array
    {
        $resultado = [];
        $dados = $this->removerCabecalhoPaginas($dados);

        $totalLinhas = count($dados);

        foreach ($dados as $indice => $linha) {
            if ($indice + 1 < $totalLinhas && is_array($dados[$indice + 1])) {
                $qntColumns = count($dados[$indice + 1]);
                if ($this->calculateHalfBox($qntColumns)) {
                    if (isset($linha[self::INDEX_COLUNA_VENDAS])) {
                        $arrayValues = $dados[$indice + 1];
                        if (isset($arrayValues[2]) && $arrayValues[2] > 0) {
                            $newValue = (int) $linha[self::INDEX_COLUNA_VENDAS] + 0.5;
                            $linha[self::INDEX_COLUNA_VENDAS] = strval($newValue);
                        }

                        if (isset($arrayValues[self::INDEX_COLUNA_VENDAS]) && $arrayValues[self::INDEX_COLUNA_VENDAS] > 0) {
                            if (str_contains($linha[self::INDEX_COLUNA_VENDAS], ',')) {
                                $linha[self::INDEX_COLUNA_VENDAS] = 0;
                                $linha[5] = $linha[self::INDEX_COLUNA_VENDAS];
                            }
                            $newValue = (float) $linha[self::INDEX_COLUNA_VENDAS];
                            $newValue = $newValue + 0.5;
                            $linha[self::INDEX_COLUNA_VENDAS] = strval($newValue);
                        }
                    }
                }

                if (count($linha) === 9) {
                    if (strpos($linha[5], ',')) {
                        array_splice($linha, 4, 0, '0');
                        array_splice($linha, 7, 0, '0,00');
                        array_splice($linha, 8, 0, '0,00');
                    }
                }
            }

            if (count($linha) === 11) {
                $linha[] = "";
            }

            if (count($linha) !== 12) {
                continue;
            }

            $linhaAssociativa = array_combine($colunas, $linha);
            $resultado[] = $linhaAssociativa;
        }

        return $resultado;
    }

    private function removerCabecalhoPaginas(array $dados): array
    {
        $valor = "*Bonif.Incorporada";

        return array_filter($dados, function ($array) use ($valor) {
            return $array[0] !== $valor;
        });
    }

    private function calculateHalfBox(int $qntColumns): bool
    {
        return match ($qntColumns) {
            self::QNT_COLUNAS_SO_BONIFICADO_MEIA_CX, self::QNT_COLUNAS_SO_BONIFICADO_OU_VENDIDO_MEIA_CX, self::QNT_COLUNAS_BONIFICADO_E_VENDIDO_MEIA_CX => true,
            default => false
        };
    }

    private function getDados(array $linhas): array
    {
        $this->dados = [];
        foreach ($linhas as $linha) {
            $colunas = explode(" ", $linha);
            $this->dados[] = $colunas;
        }
        return $this->dados;
    }

    private function removeCabecalhoPDF(array $dados): array
    {
        $dados = array_slice($dados, 1);
        $dados = array_slice($dados, 1);
        $this->dados = $dados;

        return $this->dados;
    }

    private function getLinhas(string $pdfText): array
    {
        return explode("\n", $pdfText);
    }

    private function getColunas(array $dados): array
    {
        $array = $dados[0];
        $arraySemVazios = array_filter($array, 'strlen');

        return $this->uneColunasLucTotal($arraySemVazios);
    }

    private function uneColunasLucTotal(array $colunas): array
    {
        $indiceLuc = array_search("LUC", $colunas);
        $indiceTotal = array_search("TOTAL", $colunas);

        $colunas[$indiceTotal] = "LUCTOTAL";

        unset($colunas[$indiceLuc]);

        return array_values($colunas);
    }
}
