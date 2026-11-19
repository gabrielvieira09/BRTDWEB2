<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: login.php');
    exit;
}

$email = strtolower(trim($_POST['email'] ?? ''));
$senha = $_POST['senha'] ?? '';
$senhaHash = hash('sha256', $senha);

// O login compara o mesmo SHA-256 gravado pelo cadastro.
$comando = $conexao->prepare(
    'SELECT id, nome, tipo FROM usuarios WHERE email = ? AND senha = ?'
);
$comando->execute([$email, $senhaHash]);
$usuario = $comando->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die('E-mail ou senha incorretos. <a href="login.php">Tentar novamente</a>');
}

session_start();
session_regenerate_id(true);
$_SESSION['id_usuario'] = $usuario['id'];
$_SESSION['nome'] = $usuario['nome'];
$_SESSION['tipo'] = $usuario['tipo'];

header('Location: sistema.php');
exit;
