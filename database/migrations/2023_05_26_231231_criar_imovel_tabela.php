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
        Schema::create('imoveis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_locador');
            $table->String('descricao')->Max(200);
            $table->String('cep')->Max(8)->Min(8);
            $table->String('status');
            $table->int('qtd_pessoas');
            $table->timestamps();

            $table->foreign('id_locador')->references('id')->on('locadores');
        });

        DB::statement("ALTER TABLE tabela ADD CONSTRAINT check_status CHECK (status IN ('disponível', 'locado'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imoveis');
    }
};
