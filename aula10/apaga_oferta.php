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
$id_oferta = filter_input(INPUT_POST, 'id_oferta', FILTER_VALIDATE_INT);
if (!$id_oferta || $id_oferta < 1) {
    http_response_code(400);
    exit('Oferta inválida.');
}
try {
    $conexao->beginTransaction();
    // Confere se a oferta pertence ao usuário que está logado.
    $stm = $conexao->prepare('SELECT id FROM ofertas WHERE id = ? AND id_usuario = ? FOR UPDATE');
    $stm->execute(array($id_oferta, $_SESSION['id']));
    if (!$stm->fetch()) {
        $conexao->rollBack();
        http_response_code(403);
        exit('Oferta não encontrada ou não pertence a você.');
    }
    // Remove os comentários antes de remover a oferta.
    $stm = $conexao->prepare('DELETE FROM comentarios WHERE id_oferta = ?');
    $stm->execute(array($id_oferta));
    $stm = $conexao->prepare('DELETE FROM ofertas WHERE id = ? AND id_usuario = ?');
    $stm->execute(array($id_oferta, $_SESSION['id']));
    $conexao->commit();
} catch (Exception $e) {
    if ($conexao->inTransaction()) $conexao->rollBack();
    http_response_code(500);
    exit('Não foi possível apagar a oferta.');
}
header('Location: ofertas.php', true, 303);
exit;
