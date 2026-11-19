<?php
// No XAMPP e no WampServer, normalmente o usuario e root e a senha e vazia.
$servidor = 'localhost';
$usuario = 'root';
$senhaBanco = '';
$banco = 'entregas';

try {
    $conexao = new PDO(
        "mysql:host=$servidor;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senhaBanco
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erro) {
    die('Erro ao conectar no banco de dados. Confira o conexao.php e importe entregas.sql.');
}

// Evita interpretar textos dos usuarios como codigo HTML.
function mostrar($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}
