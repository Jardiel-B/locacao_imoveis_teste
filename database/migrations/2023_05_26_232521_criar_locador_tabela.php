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
        Schema::create('locadores', function (Blueprint $table) {
            $table->id();
            $table->String('nome')->Max(200);
            $table->String('email')->Max(150)->unique();
            $table->String('cpf')->unique()->Max(11)->Min(11);
            $table->string('telefone')->Max(11)->Min(11);
            $table->string('senha')->Max(50)->Min(6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locadores');
    }
};
