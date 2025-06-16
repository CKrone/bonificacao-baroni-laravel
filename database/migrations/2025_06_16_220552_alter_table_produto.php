<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->alterDecimalColumnsPrecision(16);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->alterDecimalColumnsPrecision(8);
    }

    private function alterDecimalColumnsPrecision(int $precision): void
    {
        Schema::table('produto', function (Blueprint $table) use ($precision) {
            $table->decimal('custo', $precision)->change();
            $table->decimal('fee_hke', $precision)->change();
            $table->decimal('pis_cof', $precision)->change();
            $table->decimal('medio', $precision)->change();
            $table->decimal('preco', $precision)->change();
            $table->decimal('total', $precision)->change();
            $table->decimal('qnt_x_custo', $precision)->change();
            $table->decimal('qnt_x_venda', $precision)->change();
            $table->decimal('diferenca_reais', $precision)->change();
            $table->decimal('markup', $precision)->change();
        });
    }
};
