<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Resource Controller parcial somente leitura para consulta publica de fornecedores.
 * Apenas as acoes index() e show() ficam expostas na rota via ->only(['index', 'show']).
 */
class FornecedorController extends Controller
{
    /**
     * Lista os fornecedores homologados pela planta industrial.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'fornecedores' => $this->fornecedoresHomologados(),
        ]);
    }

    /**
     * Exibe os detalhes tecnicos de um fornecedor especifico pelo ID.
     */
    public function show(int $id): JsonResponse
    {
        $lista = $this->fornecedoresHomologados();

        if (! array_key_exists($id, $lista)) {
            return response()->json(['erro' => "Fornecedor #{$id} nao localizado."], 404);
        }

        return response()->json(['fornecedor' => $lista[$id]]);
    }

    /**
     * Base simulada de fornecedores industriais para leitura publica.
     *
     * @return array<int, array<string, mixed>>
     */
    private function fornecedoresHomologados(): array
    {
        return [
            1 => ['id' => 1, 'nome' => 'Festo Automacao Ltda', 'categoria' => 'Pneumatica'],
            2 => ['id' => 2, 'nome' => 'WEG Equipamentos Eletricos', 'categoria' => 'Motores e Inversores'],
            3 => ['id' => 3, 'nome' => 'SKF do Brasil', 'categoria' => 'Rolamentos Industriais'],
        ];
    }
}
