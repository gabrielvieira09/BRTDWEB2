<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: cadastro.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$senha = $_POST['senha'] ?? '';
$tipo = $_POST['tipo'] ?? '';

if ($nome == '' || $senha == '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Preencha nome, e-mail e senha corretamente. <a href="cadastro.php">Voltar</a>');
}

if ($tipo != 'consumidor' && $tipo != 'entregador') {
    die('Perfil invalido. <a href="cadastro.php">Voltar</a>');
}

// Verifica se o e-mail ja esta cadastrado.
$comando = $conexao->prepare('SELECT id FROM usuarios WHERE email = ?');
$comando->execute([$email]);
if ($comando->fetch()) {
    die('Este e-mail ja esta cadastrado. <a href="login.php">Fazer login</a>');
}

// O professor pediu hash("sha256", $senha).
$senhaHash = hash('sha256', $senha);

$comando = $conexao->prepare(
    'INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)'
);
$comando->execute([$nome, $email, $senhaHash, $tipo]);

echo '<h2>Usuario cadastrado com sucesso!</h2>';
echo '<p><a href="login.php">Fazer login</a></p>';
