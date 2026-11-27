<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

/**
 * Popula a base inicial com parceiros industriais de exemplo.
 */
class ClienteSeeder extends Seeder
{
    /**
     * Executa a insercao dos clientes padrao de laboratorio.
     */
    public function run(): void
    {
        $parceiros = [
            ['razao_social' => 'Bosch Rexroth Brasil', 'cnpj' => '45.990.181/0001-89', 'setor' => 'Robotica', 'status' => 'ATIVO'],
            ['razao_social' => 'Romi Maquinas Agricolas e Industriais', 'cnpj' => '56.720.428/0001-63', 'setor' => 'Usinagem', 'status' => 'ATIVO'],
            ['razao_social' => 'Mahle Metal Leve S.A.', 'cnpj' => '60.476.884/0001-87', 'setor' => 'Autopecas', 'status' => 'SUSPENSO'],
        ];

        foreach ($parceiros as $parceiro) {
            Cliente::firstOrCreate(['cnpj' => $parceiro['cnpj']], $parceiro);
        }
    }
}
