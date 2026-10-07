Autenticação de Sistema (Login Múltiplo)
Você está fazendo o Back-End de um painel administrativo. O sistema tem dois tipos de usuários que podem acessar a área VIP: "Diretor" ou "Gerente".

<?php

declare(strict_types=1);

$cargoUsuario = "Diretor";
$senhaDigitada = "SenhaSegura123";

$senhaSistema = "SenhaSegura123";

if ($senhaDigitada == $senhaSistema && ($cargoUsuario == "Diretor" || $cargoUsuario == "Gerente")) {
    echo "Acesso Liberado";
} else {
    echo "Acesso Negado";
}

?>