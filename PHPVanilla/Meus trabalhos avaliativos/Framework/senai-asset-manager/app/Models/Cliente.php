<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa um cliente ou parceiro industrial da plataforma SENAI.
 */
class Cliente extends Model
{
    /**
     * Atributos permitidos para preenchimento em massa (Mass Assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'razao_social',
        'cnpj',
        'setor',
        'status',
    ];
}
