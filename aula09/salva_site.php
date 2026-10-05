<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "site";
$conexao = new PDO("mysql:host=$servidor; dbname=$banco", $usuario, $senha);

$nome = $_POST['nome'];
$email = $_POST['email'];
$senhaUsuario = $_POST['senhaUsuario'];

$comando = "INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES (NULL, '$nome', '$email', '$senhaUsuario')";

$linhas = $conexao->exec($comando);

if($linhas > 0)
    echo "Dados salvos com sucesso!";
else
    echo "Erro ao salvar dados!";

$conexao = null;
?>