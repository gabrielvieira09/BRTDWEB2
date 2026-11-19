<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 'entregador') {
    header('Location: sistema.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: minhas_entregas.php');
    exit;
}
require 'conexao.php';

$idEntrega = (int)($_POST['id_entrega'] ?? 0);
if ($idEntrega <= 0) {
    die('Entrega invalida. <a href="minhas_entregas.php">Voltar</a>');
}

$comando = $conexao->prepare(
    "UPDATE entregas SET status = 'entregue'
     WHERE id = ? AND id_entregador = ? AND status = 'em_rota'"
);
$comando->execute([$idEntrega, $_SESSION['id_usuario']]);

header('Location: minhas_entregas.php');
exit;
