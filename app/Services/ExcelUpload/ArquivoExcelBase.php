<?php

namespace App\Services\ExcelUpload;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Exception;

class ArquivoExcelBase
{
    protected array $colunas = [];
    protected string $arquivoPath;
    /**
     * @var Spreadsheet
     */
    protected Spreadsheet $phpExcel;
    /**
     * @var Worksheet
     */
    protected Worksheet $worksheet;
    /**
     * @var bool
     */
    protected bool $verificarTodasColunas = true;
    private array $rowsToDelete = [
        'VALORES CATEGORIA',
        'MARKUP CATEGORIA',
        'PREÇO MÉDIO BARONI BEBIDAS ',
        'EMBALAGEM / PRODUTO'
    ];
    private array $rowsNullNoToDelete = [];
    private const QNT_ROWS_TO_DELETE_FINAL_FILE = 5;
    private const INDEX_COLUNAS = 0;

    private array $idRowsDeleted = [];

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function __construct(string $arquivoPath)
    {
        $this->arquivoPath = $arquivoPath;
        $this->phpExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($arquivoPath);
        $this->worksheet = $this->phpExcel->getSheet(0);
    }

    public function definirColunas($nome, $label, $params = []): void
    {
        $params = array_replace_recursive(
            [
                'multiplosValores' => false,
            ],
            $params
        );

        $this->colunas[] = [
            'nome' => $nome,
            'label' => $label,
            'labelFormatado' => $this->trataLabel($label),
            'params' => $params
        ];
    }

    protected function trataLabel($label): string
    {
        return $label;
    }

    protected function procurarColunaPorLabel($label): mixed
    {
        $result = null;
        foreach ($this->colunas as $coluna) {
            $isMultipleValues = $coluna['params']['multiplosValores'];
            if ($isMultipleValues) {
                $matches = [];
                if (preg_match('/^' . preg_quote($coluna['labelFormatado']) . ' (\d)+$/', $label, $matches) === 1) {
                    $coluna['index'] = $matches[1];
                    $result = $coluna;
                }
            }

            if (! $isMultipleValues) {
                if ($coluna['labelFormatado'] === $label) {
                    $result = $coluna;
                }
            }
        }
        return $result;
    }

    protected function maxColumn(): string
    {
        $col = 'A';
        $last = 'A';
        for($i = 0; $i < 1000; $i++) {
            $a = $this->worksheet->getCell($col . '1')->getValue();
            if ($a === null) {
                return $last;
            }
            $last = $col;
            $col++;
        }
        return 'Z';
    }

    protected function maxRow(): string
    {
        for ($i = 1; $i < 90000; $i++) {
            $a = $this->worksheet->getCell('A' . $i)->getValue();
            if ($a === 'VALORES CATEGORIA') {
                $this->rowsNullNoToDelete[] = $i + 2;
            }

            if ($a === null && ! in_array($i, $this->rowsNullNoToDelete)) {
                return $i - self::QNT_ROWS_TO_DELETE_FINAL_FILE;
            }
        }
        return 90000;
    }

    private function removeRows(array $data): array
    {
        foreach ($data as $index => $item)  {
            if ($index === self::INDEX_COLUNAS) {
                continue;
            }

            if ($this->itemToDelete($item)) {
                $this->idRowsDeleted[] = $index;
                unset($data[$index]);
            }
        }
        return array_values($data);
    }

    private function itemToDelete(array $item): bool
    {
        foreach ($this->rowsToDelete as $row) {
            if (in_array($row, $item)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function getArrayDados(): array
    {
        $this->worksheet->removeColumn('A');
        $this->worksheet->removeRow(1);

        $data = $this->worksheet->rangeToArray('A1:' . $this->maxColumn() . $this->maxRow(),
        null, calculateFormulas: true, formatData: true, returnCellRef: false);
        $data = $this->removeRows($data);

        $columns = [];
        if (isset($data[0])) {
            foreach ($data[0] as $i => $col) {
                if ($col === null) {
                    continue;
                }
                $colunaFormatada = $this->trataLabel($col);
                $defCol = $this->procurarColunaPorLabel($colunaFormatada);

                if (false === $defCol) {
                    throw new Exception('Coluna '. $col . ' não reconhecida');
                }

                $columns[$i] = $defCol;

                if (! $this->verificarTodasColunas && (count($columns) === count($this->colunas))) {
                    break;
                }
            }
        }

        $result = [];
        for ($i = 1; $i < count($data); $i++) {
            $item = [];
            $linhaComDado = false;
            for($j = 0; $j < count($columns); $j++) {
                $currentColumn = $columns[$j];
                $dado = trim($data[$i][$j]);

                if (! empty($dado)) {
                    $linhaComDado = true;
                }

                $isMultipleValues = $currentColumn['params']['multiplosValores'];
                if ($isMultipleValues) {
                    if (! isset($item[$currentColumn['nome']])) {
                        $item[$currentColumn['nome']] = [];
                    }
                    $item[$currentColumn['nome']][$currentColumn['index']] = $dado;
                }

                if (! $isMultipleValues) {
                    $item[$currentColumn['nome']] = $dado;
                }
            }

            if (false === $linhaComDado) {
                break;
            }
            $result[] = $item;
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getIdRowsDeleted(): array
    {
        return $this->idRowsDeleted;
    }
}
