<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 'entregador') {
    header('Location: sistema.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: entregador.php');
    exit;
}
require 'conexao.php';

$idEntrega = (int)($_POST['id_entrega'] ?? 0);
if ($idEntrega <= 0) {
    die('Entrega invalida. <a href="entregador.php">Voltar</a>');
}

// So aceita se ainda estiver disponivel; impede 2 entregadores de aceitarem.
$comando = $conexao->prepare(
    "UPDATE entregas
     SET id_entregador = ?, status = 'em_rota'
     WHERE id = ? AND status = 'disponivel' AND id_entregador IS NULL"
);
$comando->execute([$_SESSION['id_usuario'], $idEntrega]);

if ($comando->rowCount() == 0) {
    die('Esta entrega nao esta mais disponivel. <a href="entregador.php">Voltar</a>');
}

header('Location: minhas_entregas.php');
exit;
