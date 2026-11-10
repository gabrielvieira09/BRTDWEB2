<?php
require('conexao.php');

// print_r($_POST);
$email = $_POST['email'];
$senha = $_POST['senha'];

$comando = "INSERT INTO `usuarios` (`id`, `email`, `nome`, `senha`) VALUES (NULL, '$email', '{$_POST['nome']}', '$senha')";

$linhas = $conexao->exec($comando);

if($linhas > 0) {
    echo "Usuário cadastrado com sucesso!";
} else {
    echo "Erro no cadastro.";
}

?>