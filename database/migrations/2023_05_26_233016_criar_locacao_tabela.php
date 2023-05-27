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
        Schema::create('locacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_locador');
            $table->unsignedBigInteger('id_locatario');
            $table->unsignedBigInteger('id_imovel');
            $table->String('valor_final')->Max(200);
            $table->String('status');
            $table->int('qtd_dias');
            $table->timestamps();

            $table->foreign('id_locador')->references('id')->on('locadores');
            $table->foreign('id_locatarios')->references('id')->on('locatarios');
            $table->foreign('id_imoveis')->references('id')->on('imoveis');
        });

        DB::statement("ALTER TABLE tabela ADD CONSTRAINT check_status CHECK (status IN ('ativa', 'cancelada'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locacoes');
    }
};
