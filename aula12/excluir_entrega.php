<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 'gerente') {
    header('Location: sistema.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: gerente.php');
    exit;
}
require 'conexao.php';

$idEntrega = (int)($_POST['id_entrega'] ?? 0);
if ($idEntrega <= 0) {
    die('Entrega invalida. <a href="gerente.php">Voltar</a>');
}

$comando = $conexao->prepare('DELETE FROM entregas WHERE id = ?');
$comando->execute([$idEntrega]);

header('Location: gerente.php');
exit;
