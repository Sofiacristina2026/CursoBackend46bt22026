<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Executa a construcao da tabela categorias no banco de dados.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table): void {
            $table->id();
            $table->string('nome', 60)->unique();
            $table->string('slug', 80)->unique();
            $table->text('descricao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverte integralmente a operacao removendo a tabela categorias.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
