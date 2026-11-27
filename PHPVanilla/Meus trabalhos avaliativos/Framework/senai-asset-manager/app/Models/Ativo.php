<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa um ativo de producao da fabrica (maquina/equipamento).
 *
 * Nesta atividade os dados de ativos sao simulados em memoria, portanto o
 * modelo nao depende de uma tabela fisica para funcionar nos exercícios.
 */
class Ativo extends Model
{
    /**
     * Indica se o modelo utiliza carimbos de data/hora automaticos (created_at, updated_at).
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'nome',
        'setor',
        'status',
        'tensao',
        'horas_uso',
    ];
}
