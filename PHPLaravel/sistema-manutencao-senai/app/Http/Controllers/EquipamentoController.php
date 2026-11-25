<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class EquipamentoController extends Controller
{
    /**
     * Tela para exibir os equipamentos cadastrados
     */
    public function index(): View {
        return view('equipamentos.index', [
            'equipamentos' => Equipamento::query()->latest()->get(),
            'titulo'       => 'Parque de Máquinas e Equipamentos Industriais',
        ]);
    }

    /**
     * tela para exibir o formulário de cadastro de equipamento
     */
    public function create(): View {
        return view('equipamentos.create', [
            'titulo' => 'Cadastrar Equipamento',
        ]);
    }

    /**
     * permite cadastrar um novo equipamento no BD
     */
    public function store(Request $request): RedirectResponse {
        Equipamento::create($this->validar($request));

        return redirect()->route('equipamentos.index')
            ->with('mensagem_sucesso', 'Equipamento cadastrado com sucesso!');
    }

    /**
     * Exibe os dados detalhados de um equipamento.
     */
    public function show(Equipamento $equipamento): View {
        return view('equipamentos.show', [
            'equipamento' => $equipamento,
            'titulo'      => "Equipamento {$equipamento->tag}",
        ]);
    }

    /**
     * exibir um formulário para editar
     */
    public function edit(Equipamento $equipamento): View {
        return view('equipamentos.edit', [
            'equipamento' => $equipamento,
            'titulo'      => 'Editar Equipamento',
        ]);
    }

    /**
     * Valida e atualiza os dados do equipamento no banco de dados.
     */
    public function update(Request $request, Equipamento $equipamento): RedirectResponse {
        $equipamento->update($this->validar($request, $equipamento->id));

        return redirect()->route('equipamentos.index')
            ->with('mensagem_sucesso', 'Equipamento atualizado com sucesso!');
    }

    /**
     * Remove um equipamento da base de dados
     */
     public function destroy(Equipamento $equipamento): RedirectResponse {
        $equipamento->delete();

        return redirect()->route('equipamentos.index')
            ->with('mensagem_sucesso', 'Equipamento removido com sucesso!');
    }


    //função para validar dados antes de qualquer coisa(cadastrar/atualizar e deletar)
    private function validar(Request $request, ?int $id = null): array {
        $regraTag = 'required|string|max:255|unique:equipamentos,tag' . ($id ? ",{$id}" : '');

        return $request->validate([
            'tag'         => $regraTag,
            'nome'        => 'required|string|max:255',
            'setor'       => 'required|string|max:255',
            'criticidade' => 'required|in:BAIXA,MEDIA,ALTA,CRITICA',
            'status'      => 'required|in:OPERANDO,MANUTENCAO,PARADO',
        ]);
    }
}
