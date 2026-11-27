<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Fornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para geracao de fornecedores e distribuidores brasileiros.
 *
 * @extends Factory<Fornecedor>
 */
final class FornecedorFactory extends Factory
{
    protected $model = Fornecedor::class;

    /**
     * Define o estado padrao dos atributos do fornecedor.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'razao_social' => fake()->company() . ' ' . fake()->companySuffix(),
            'cnpj' => fake()->unique()->numerify('##.###.###/0001-##'),
            'email' => fake()->companyEmail(),
            'telefone' => fake()->phoneNumber(),
            'cidade' => fake()->city(),
            'estado' => fake()->stateAbbr(),
        ];
    }
}
