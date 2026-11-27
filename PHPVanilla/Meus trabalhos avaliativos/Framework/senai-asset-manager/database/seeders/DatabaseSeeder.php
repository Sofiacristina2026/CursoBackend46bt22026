<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeder principal da aplicacao SENAI Asset Manager.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Executa todos os seeders registrados no projeto.
     */
    public function run(): void
    {
        $this->call(ClienteSeeder::class);
    }
}
