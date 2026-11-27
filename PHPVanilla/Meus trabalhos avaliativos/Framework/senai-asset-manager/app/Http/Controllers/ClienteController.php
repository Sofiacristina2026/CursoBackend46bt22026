<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Resource Controller responsavel pela gestao RESTful de clientes e parceiros industriais.
 */
class ClienteController extends Controller
{
    /**
     * Lista todos os parceiros industriais cadastrados na base.
     */
    public function index(): View
    {
        return view('clientes.index', [
            'clientes' => Cliente::orderBy('id')->get(),
            'titulo' => 'Parceiros e Clientes Industriais',
        ]);
    }

    /**
     * Exibe o formulario de cadastro de um novo parceiro industrial.
     */
    public function create(): View
    {
        return view('clientes.create', [
            'titulo' => 'Novo Cadastro de Parceiro Industrial',
        ]);
    }

    /**
     * Valida e persiste um novo cliente recebido via requisicao POST.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validacao enxuta para manter a responsabilidade unica no controller
        $dados = $request->validate([
            'razao_social' => ['required', 'string', 'min:3', 'max:150'],
            'cnpj' => ['required', 'string', 'unique:clientes,cnpj'],
            'setor' => ['required', 'string', 'max:80'],
        ]);

        Cliente::create($dados + ['status' => 'ATIVO']);

        return redirect()->route('clientes.index')->with('sucesso', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Exibe a ficha tecnica detalhada de um cliente especifico.
     */
    public function show(int $id): View
    {
        $cliente = Cliente::findOrFail($id);

        return view('clientes.show', [
            'cliente' => $cliente,
            'titulo' => "Ficha Técnica: {$cliente->razao_social}",
        ]);
    }

    /**
     * Exibe o formulario de edicao de um cliente existente.
     */
    public function edit(int $id): View
    {
        $cliente = Cliente::findOrFail($id);

        return view('clientes.edit', [
            'cliente' => $cliente,
            'titulo' => "Editar Parceiro: {$cliente->razao_social}",
        ]);
    }

    /**
     * Atualiza os dados cadastrais do cliente via Method Spoofing (PUT).
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $dados = $request->validate([
            'razao_social' => ['required', 'string', 'min:3', 'max:150'],
            'setor' => ['required', 'string', 'max:80'],
        ]);

        Cliente::findOrFail($id)->update($dados);

        return redirect()->route('clientes.show', $id)->with('sucesso', 'Dados atualizados com sucesso!');
    }

    /**
     * Remove o cliente do banco de dados via verbo semantico DELETE.
     */
    public function destroy(int $id): RedirectResponse
    {
        Cliente::findOrFail($id)->delete();

        return redirect()->route('clientes.index')->with('sucesso', 'Parceiro removido do sistema!');
    }

    /**
     * Filtra parceiros industriais pelo segmento informado na rota.
     */
    public function filtrarPorSetor(?string $setor = null): View
    {
        $consulta = Cliente::query();

        if ($setor !== null) {
            $consulta->whereRaw('LOWER(setor) = ?', [mb_strtolower($setor)]);
        }

        return view('clientes.index', [
            'clientes' => $consulta->orderBy('id')->get(),
            'titulo' => $setor !== null ? 'Setor: '.ucfirst($setor) : 'Todos os Setores',
        ]);
    }

    /**
     * Exercicio 1: Lista os contratos de um cliente filtrados por ano (4 digitos).
     */
    public function contratosPorAno(int $cliente, int $ano): JsonResponse
    {
        $parceiro = Cliente::findOrFail($cliente);

        // Contratos simulados para o parceiro no exercicio solicitado
        $contratos = [
            ['codigo' => "CTR-{$ano}-01", 'objeto' => 'Manutencao Preventiva CNC', 'status' => 'VIGENTE'],
            ['codigo' => "CTR-{$ano}-02", 'objeto' => 'Calibracao de Sensores IIoT', 'status' => 'CONCLUIDO'],
        ];

        return response()->json([
            'cliente_id' => $parceiro->id,
            'razao_social' => $parceiro->razao_social,
            'ano' => $ano,
            'contratos' => $contratos,
        ]);
    }

    /**
     * Exercicio 3: Extrai metadados de rede (IP e User-Agent) via Injeção de Dependencia.
     */
    public function origemRequisicao(Request $request): JsonResponse
    {
        return response()->json([
            'ip_cliente' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metodo_http' => $request->method(),
            'rota_atual' => $request->path(),
        ]);
    }

    /**
     * Exercicio 4: Retorna o total de parceiros ativos para auditoria administrativa.
     */
    public function auditoriaAtivos(): JsonResponse
    {
        $totalAtivos = Cliente::where('status', 'ATIVO')->count();

        return response()->json([
            'endpoint' => route('admin.auditoria.clientes'),
            'total_parceiros_ativos' => $totalAtivos,
            'total_geral_cadastrado' => Cliente::count(),
        ]);
    }

    /**
     * Exercicio 5: Alterna o status do cliente entre ATIVO e SUSPENSO via PATCH.
     */
    public function alterarStatus(Request $request, int $id): RedirectResponse
    {
        $cliente = Cliente::findOrFail($id);
        $novoStatus = $cliente->status === 'ATIVO' ? 'SUSPENSO' : 'ATIVO';

        $cliente->update(['status' => $novoStatus]);

        return redirect()->route('clientes.index')->with(
            'sucesso',
            "Status de {$cliente->razao_social} alterado para {$novoStatus}."
        );
    }
}
