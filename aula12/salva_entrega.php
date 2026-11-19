<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 'consumidor') {
    header('Location: sistema.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: consumidor.php');
    exit;
}

require 'conexao.php';

$largura = $_POST['largura'] ?? '';
$altura = $_POST['altura'] ?? '';
$profundidade = $_POST['profundidade'] ?? '';
$peso = $_POST['peso'] ?? '';
$sensivel = $_POST['sensivel'] ?? '';

// Campos numericos e maiores que zero.
if (!is_numeric($largura) || !is_numeric($altura) ||
    !is_numeric($profundidade) || !is_numeric($peso) ||
    $largura <= 0 || $altura <= 0 || $profundidade <= 0 || $peso <= 0 ||
    $largura > 99999999 || $altura > 99999999 ||
    $profundidade > 99999999 || $peso > 99999999) {
    die('Informe as medidas corretamente. <a href="consumidor.php">Voltar</a>');
}

if ($sensivel != 'sim' && $sensivel != 'nao') {
    die('Escolha se o conteudo e sensivel. <a href="consumidor.php">Voltar</a>');
}

// Sem entregador ate alguem aceitar. Status inicial: disponivel.
$comando = $conexao->prepare(
    "INSERT INTO entregas
     (id_consumidor, id_entregador, largura, altura, profundidade, peso, sensivel, status)
     VALUES (?, NULL, ?, ?, ?, ?, ?, 'disponivel')"
);
$comando->execute([
    $_SESSION['id_usuario'], $largura, $altura, $profundidade, $peso, $sensivel
]);

header('Location: minhas_solicitacoes.php');
exit;
