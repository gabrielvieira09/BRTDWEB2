<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirPost();

$email = trim((string)($_POST['email'] ?? ''));
$senha = (string)($_POST['senha'] ?? '');
$senhaHash = hash('sha256', $senha);

$consulta = $conexao->prepare('SELECT id, nome, nascimento FROM usuarios WHERE email = ? AND senha = ? LIMIT 1');
$consulta->execute(array($email, $senhaHash));
$usuario = $consulta->fetch();

session_regenerate_id(true);
$_SESSION['id_usuario'] = (int)$usuario['id'];
$_SESSION['nome'] = $usuario['nome'];
$_SESSION['idade'] = $idade;

avisar('Bem-vindo(a), ' . $usuario['nome'] . '!');
redirecionar('filmes.php');
