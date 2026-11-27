<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Controller de telemetria e detalhamento dos ativos fabris da plataforma SENAI.
 */
class AtivoController extends Controller
{
    /**
     * Retorna a relacao dos tres principais setores da fabrica com suas
     * respectivas quantidades de maquinas e status medio de eficiencia.
     *
     * @return JsonResponse JSON com a lista de setores fabris
     */
    public function setores(): JsonResponse
    {
        // Dados simulados de telemetria dos setores fabris
        $setores = [
            ['nome' => 'Usinagem', 'quantidade_maquinas' => 12, 'eficiencia_media' => 94.5],
            ['nome' => 'Estamparia', 'quantidade_maquinas' => 8, 'eficiencia_media' => 88.2],
            ['nome' => 'Montagem Robótica', 'quantidade_maquinas' => 15, 'eficiencia_media' => 96.1],
        ];

        return response()->json(['setores' => $setores]);
    }

    /**
     * Retorna os detalhes tecnicos de um ativo identificado pelo codigo corporativo.
     *
     * @param  string  $codigo  Codigo do ativo no formato PAT-001
     * @return JsonResponse JSON com os detalhes tecnicos ou erro
     */
    public function detalhar(string $codigo): JsonResponse
    {
        // Valida o formato padrao corporativo (ex.: PAT-001, PAT-002)
        if (! preg_match('/^PAT-\d{3}$/', $codigo)) {
            return response()->json(['erro' => 'Codigo invalido. Use o formato PAT-001.'], 400);
        }

        // Lista simulada de ativos cadastrados na fabrica
        $ativos = ['PAT-001' => ['tensao' => '220V', 'horas_uso' => 1240], 'PAT-002' => ['tensao' => '110V', 'horas_uso' => 890], 'PAT-003' => ['tensao' => '380V', 'horas_uso' => 2100]];

        if (! array_key_exists($codigo, $ativos)) {
            return response()->json(['erro' => "Ativo {$codigo} nao encontrado na fabrica."], 404);
        }

        return response()->json(['codigo' => $codigo, 'detalhes' => $ativos[$codigo]]);
    }

    /**
     * Endpoint leve de verificacao de saude e uptime da aplicacao (Health Check).
     *
     * @return JsonResponse JSON com status UP, uptime e memoria utilizada
     */
    public function saude(): JsonResponse
    {
        return response()->json([
            'status' => 'UP',
            'uptime_segundos' => microtime(true) - LARAVEL_START,
            'memoria_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
        ]);
    }
}
