<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeder para carga inicial das categorias principais da loja de informatica.
 */
final class CategoriaSeeder extends Seeder
{
    /**
     * Executa o povoamento das categorias mestras.
     */
    public function run(): void
    {
        $categorias = [
            'Processadores',
            'Placas de Vídeo',
            'Memórias RAM',
            'Armazenamento SSD',
            'Periféricos',
            'Monitores',
        ];

        foreach ($categorias as $cat) {
            Categoria::firstOrCreate(['nome' => $cat], [
                'slug' => Str::slug($cat),
                'descricao' => "Produtos e componentes de informática da linha {$cat}.",
                'ativo' => true,
            ]);
        }
    }
}
