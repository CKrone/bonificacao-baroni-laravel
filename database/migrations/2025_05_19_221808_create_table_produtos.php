<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->id();
            $table->string('produto');
            $table->integer('codigo');
            $table->decimal('custo');
            $table->string('fee_hke');
            $table->decimal('pis_cof');
            $table->decimal('medio');
            $table->integer('qtde');
            $table->decimal('preco');
            $table->decimal('total');
            $table->decimal('qnt_x_custo');
            $table->decimal('qnt_x_venda');
            $table->decimal('diferenca_reais');
            $table->decimal('markup');
            $table->index([
                'produto',
                'codigo'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produto');
    }
};
