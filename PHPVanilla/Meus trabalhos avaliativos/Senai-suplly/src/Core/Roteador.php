namespace App\Core;

class Roteador {
    private array $rotas = [];

    public function registrar(string $metodo, string $caminho, string $controller, string $acao, array $perfis = []): void {
        $this->rotas[] = [
            'metodo' => strtoupper($metodo),
            'caminho' => $caminho,
            'controller' => $controller,
            'acao' => $acao,
            'perfis' => $perfis
        ];
    }

    public function despachar(string $metodoRequisicao, string $uriRequisicao): void {
        $caminhoParsed = parse_url($uriRequisicao, PHP_URL_PATH);

        foreach ($this->rotas as $rota) {
            if ($rota['metodo'] === $metodoRequisicao && $rota['caminho'] === $caminhoParsed) {
                // Aplica o Guard de Acesso
                AuthGuard::verificar($rota['perfis']);

                $nomeController = "App\\Controllers\\" . $rota['controller'];
                if (class_exists($nomeController)) {
                    $instanciaController = new $nomeController();
                    $acao = $rota['acao'];
                    if (method_exists($instanciaController, $acao)) {
                        $instanciaController->$acao();
                        return;
                    }
                }
                http_response_code(500);
                echo "Erro interno: Controller ou Ação não encontrados.";
                return;
            }
        }

        http_response_code(404);
        echo "<h1>404 Not Found</h1><p>A rota solicitada não existe.</p>";
    }
}