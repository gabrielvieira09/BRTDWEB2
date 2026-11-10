<?php
require('conexao.php');
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    exit('Faça login para comentar.');
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}
$id_oferta = filter_input(INPUT_POST, 'id_oferta', FILTER_VALIDATE_INT);
$comentario = trim(isset($_POST['comentario']) ? $_POST['comentario'] : '');
if (!$id_oferta || $id_oferta < 1 || $comentario === '' || mb_strlen($comentario, 'UTF-8') > 2000) {
    http_response_code(400);
    exit('Comentário ou oferta inválidos.');
}
$stm = $conexao->prepare('SELECT id FROM ofertas WHERE id = ?');
$stm->execute(array($id_oferta));
if (!$stm->fetch()) {
    http_response_code(404);
    exit('Oferta não encontrada.');
}
$stm = $conexao->prepare('INSERT INTO comentarios (id_usuario, id_oferta, comentario) VALUES (?, ?, ?)');
$stm->execute(array($_SESSION['id'], $id_oferta, $comentario));
header('Location: detalhe_oferta.php?id=' . $id_oferta, true, 303);
exit;
