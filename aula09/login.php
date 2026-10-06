<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "site";

$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

$nome = $_GET['nome'];
$email = $_GET['email'];

$comando = "SELECT `nome` FROM `usuarios` WHERE `nome` = '$nome' AND `email` = '$email'";

$stm = $conexao->prepare($comando);
$stm->execute();

if($resultado = $stm->fetch(PDO::FETCH_ASSOC))
    $_SESSION['nome'] = $resultado['nome'];
else
    echo 'Usuário não cadastrado.'
?>