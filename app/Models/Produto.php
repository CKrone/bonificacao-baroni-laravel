<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produto';
    protected $fillable = [
        'id',
        'produto',
        'codigo',
        'custo',
        'fee_hke',
        'pis_cof',
        'medio',
        'qtde',
        'total',
        'preco',
        'qnt_x_custo',
        'qnt_x_venda',
        'diferenca_reais',
        'markup',
    ];
    public $timestamps = false;
}
