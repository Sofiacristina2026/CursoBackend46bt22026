<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Fornecedor;
use Illuminate\Database\Seeder;

/**
 * Seeder para carga inicial de distribuidores e fabricantes de tecnologia.
 */
final class FornecedorSeeder extends Seeder
{
    /**
     * Executa a geracao de 10 fornecedores via Model Factory.
     */
    public function run(): void
    {
        Fornecedor::factory()->count(10)->create();
    }
}
