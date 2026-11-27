<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Fornecedor;
use App\Models\Produto;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Testes automatizados de homologacao da aplicacao SENAI Tech Store.
 */
class TechStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste 4 e 5: Seeders e Factories geram 6 categorias, 10 fornecedores e 100 produtos.
     */
    public function test_seeders_e_factories_povoam_o_banco_corretamente(): void
    {
        $this->seed();

        $this->assertSame(6, Categoria::count());
        $this->assertSame(10, Fornecedor::count());
        $this->assertSame(100, Produto::count());

        $produto = Produto::with(['categoria', 'fornecedor'])->firstOrFail();
        $this->assertNotNull($produto->categoria);
        $this->assertNotNull($produto->fornecedor);
        $this->assertStringStartsWith('TEC-', $produto->sku);
    }

    /**
     * Teste 7: Rota raiz redireciona e catalogo renderiza KPIs, produtos e filtro.
     */
    public function test_catalogo_renderiza_produtos_kpis_e_filtro_por_categoria(): void
    {
        $this->seed();

        $this->get('/')->assertRedirect('/catalogo');

        $categoria = Categoria::firstOrFail();

        $this->get(route('catalogo.index'))
            ->assertOk()
            ->assertSee('Painel de Produtos')
            ->assertSee('Produtos Cadastrados');

        $this->get(route('catalogo.index', ['categoria_id' => $categoria->id]))
            ->assertOk()
            ->assertSee($categoria->nome);
    }

    /**
     * Teste 8: Garante integridade referencial (restrictOnDelete) ao tentar excluir categoria com produtos.
     */
    public function test_restrict_on_delete_impede_exclusao_de_categoria_com_produtos(): void
    {
        $this->seed();

        $categoria = Categoria::whereHas('produtos')->firstOrFail();

        $this->expectException(QueryException::class);
        $categoria->delete();
    }
}
