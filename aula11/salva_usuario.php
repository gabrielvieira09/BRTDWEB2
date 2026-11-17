<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirPost();

$nome = trim((string)($_POST['nome'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$nascimento = trim((string)($_POST['nascimento'] ?? ''));
$senha = (string)($_POST['senha'] ?? '');
$senhaHash = hash('sha256', $senha);

$consulta = $conexao->prepare('INSERT INTO usuarios (nome, email, nascimento, senha) VALUES (?, ?, ?, ?)');
$consulta->execute(array($nome, $email, $nascimento, $senhaHash));

avisar('Usuario cadastrado com sucesso!');
redirecionar('login.php');
