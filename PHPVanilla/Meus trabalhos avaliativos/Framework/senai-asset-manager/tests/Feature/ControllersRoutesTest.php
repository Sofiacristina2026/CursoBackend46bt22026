<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Testes automatizados para os exercicios de Controllers e Routes no Laravel.
 */
class ControllersRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Valida o CRUD completo de clientes com verbos semanticos e CSRF.
     */
    public function test_crud_completo_de_clientes_funciona(): void
    {
        $this->post(route('clientes.store'), [
            'razao_social' => 'Siemens Automacao Industrial',
            'cnpj' => '12.345.678/0001-90',
            'setor' => 'Robotica',
        ])->assertRedirect(route('clientes.index'));

        $cliente = Cliente::firstOrFail();

        $this->get(route('clientes.index'))->assertOk()->assertSee('Siemens Automacao Industrial');
        $this->get(route('clientes.show', $cliente->id))->assertOk();
        $this->get(route('clientes.edit', $cliente->id))->assertOk();

        $this->put(route('clientes.update', $cliente->id), [
            'razao_social' => 'Siemens Energy Automation',
            'setor' => 'Usinagem',
        ])->assertRedirect(route('clientes.show', $cliente->id));

        $this->assertDatabaseHas('clientes', ['id' => $cliente->id, 'razao_social' => 'Siemens Energy Automation']);

        $this->delete(route('clientes.destroy', $cliente->id))->assertRedirect(route('clientes.index'));
        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }

    /**
     * Exercicio 1: Valida rota com multiplos parametros e constraints compostas.
     */
    public function test_contratos_por_ano_respeita_constraints(): void
    {
        $cliente = Cliente::create([
            'razao_social' => 'Bosch Rexroth',
            'cnpj' => '45.990.181/0001-89',
            'setor' => 'Robotica',
            'status' => 'ATIVO',
        ]);

        $this->get("/clientes/{$cliente->id}/contratos/2026")
            ->assertOk()
            ->assertJsonFragment(['cliente_id' => $cliente->id, 'ano' => 2026]);

        $this->get('/clientes/abc/contratos/2026')->assertNotFound();
        $this->get("/clientes/{$cliente->id}/contratos/26")->assertNotFound();
    }

    /**
     * Exercicio 2: Comprova que o recurso fornecedores expoe apenas index e show.
     */
    public function test_fornecedores_expoe_somente_leitura(): void
    {
        $this->get(route('fornecedores.index'))->assertOk();
        $this->get(route('fornecedores.show', 1))->assertOk();
        $this->get('/fornecedores/create')->assertNotFound();
        $this->post('/fornecedores', [])->assertStatus(405);
    }

    /**
     * Exercicio 3: Valida telemetria de rede (IP e User-Agent) via Request injection.
     */
    public function test_origem_requisicao_retorna_telemetria_de_rede(): void
    {
        $this->withHeaders(['User-Agent' => 'SenaiTestAgent/1.0'])
            ->get(route('clientes.origem'))
            ->assertOk()
            ->assertJsonStructure(['ip_cliente', 'user_agent', 'metodo_http', 'rota_atual'])
            ->assertJsonFragment(['user_agent' => 'SenaiTestAgent/1.0']);
    }

    /**
     * Exercicio 4: Valida grupo administrativo /admin, nome admin. e middleware.
     */
    public function test_auditoria_admin_retorna_contagem_de_ativos(): void
    {
        Cliente::create(['razao_social' => 'Ativo 1', 'cnpj' => '11.111.111/0001-11', 'setor' => 'Usinagem', 'status' => 'ATIVO']);
        Cliente::create(['razao_social' => 'Suspenso 1', 'cnpj' => '22.222.222/0001-22', 'setor' => 'Usinagem', 'status' => 'SUSPENSO']);

        $url = route('admin.auditoria.clientes');
        $this->assertStringEndsWith('/admin/auditoria/clientes', $url);

        $this->get($url)
            ->assertOk()
            ->assertHeader('X-Senai-Admin-Audit', 'ativo')
            ->assertJsonFragment(['total_parceiros_ativos' => 1, 'total_geral_cadastrado' => 2]);
    }

    /**
     * Exercicio 5: Valida alteracao parcial de status via PATCH e botao na tabela.
     */
    public function test_patch_alterna_status_entre_ativo_e_suspenso(): void
    {
        $cliente = Cliente::create([
            'razao_social' => 'Romi Industrial',
            'cnpj' => '56.720.428/0001-63',
            'setor' => 'Usinagem',
            'status' => 'ATIVO',
        ]);

        $this->get(route('clientes.index'))
            ->assertOk()
            ->assertSee('name="_method" value="PATCH"', false);

        $this->patch(route('clientes.status', $cliente->id))->assertRedirect(route('clientes.index'));
        $this->assertSame('SUSPENSO', $cliente->fresh()?->status);

        $this->patch(route('clientes.status', $cliente->id))->assertRedirect(route('clientes.index'));
        $this->assertSame('ATIVO', $cliente->fresh()?->status);
    }

    /**
     * Valida restricao alfanumerica na rota de filtro por setor.
     */
    public function test_filtro_por_setor_valida_constraint_alfanumerica(): void
    {
        Cliente::create(['razao_social' => 'Mahle', 'cnpj' => '60.476.884/0001-87', 'setor' => 'Autopecas', 'status' => 'ATIVO']);

        $this->get(route('clientes.setor', 'Autopecas'))->assertOk()->assertSee('Mahle');
        $this->get('/clientes/setor/auto-pecas')->assertNotFound();
    }
}
