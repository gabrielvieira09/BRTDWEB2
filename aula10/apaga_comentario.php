<?php
require('conexao.php');
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403);
    exit('Faça login.');
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}
$id_comentario = filter_input(INPUT_POST, 'id_comentario', FILTER_VALIDATE_INT);
if (!$id_comentario || $id_comentario < 1) {
    http_response_code(400);
    exit('Comentário inválido.');
}
$stm = $conexao->prepare('SELECT id_oferta FROM comentarios WHERE id = ? AND id_usuario = ?');
$stm->execute(array($id_comentario, $_SESSION['id']));
$comentario = $stm->fetch(PDO::FETCH_ASSOC);
if (!$comentario) {
    http_response_code(403);
    exit('Comentário não encontrado ou não pertence a você.');
}
$stm = $conexao->prepare('DELETE FROM comentarios WHERE id = ? AND id_usuario = ?');
$stm->execute(array($id_comentario, $_SESSION['id']));
header('Location: detalhe_oferta.php?id=' . $comentario['id_oferta'], true, 303);
exit;
