<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a criacao da tabela de clientes industriais.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table): void {
            $table->id();
            $table->string('razao_social');
            $table->string('cnpj')->unique();
            $table->string('setor');
            $table->string('status')->default('ATIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverte a migracao removendo a tabela de clientes.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
