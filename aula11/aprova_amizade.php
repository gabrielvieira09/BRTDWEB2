<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirLogin();
exigirPost();
$idPendente = filter_var($_POST['id_pendente'] ?? null, FILTER_VALIDATE_INT);

try {
    $conexao->beginTransaction();
    $consulta = $conexao->prepare('SELECT id_usuario, id_amigo FROM pendente WHERE id = ? AND id_amigo = ? FOR UPDATE');
    $consulta->execute(array($idPendente, $_SESSION['id_usuario']));
    $pedido = $consulta->fetch();

    $solicitante = (int)$pedido['id_usuario'];
    $destinatario = (int)$pedido['id_amigo'];

    $verifica = $conexao->prepare('SELECT id FROM amigos WHERE id_usuario = ? AND id_amigo = ? LIMIT 1');
    $insere = $conexao->prepare('INSERT INTO amigos (id_usuario, id_amigo) VALUES (?, ?)');
    foreach (array(array($solicitante, $destinatario), array($destinatario, $solicitante)) as $par) {
        $verifica->execute($par);
        if (!$verifica->fetch()) $insere->execute($par);
    }

    $consulta = $conexao->prepare('DELETE FROM pendente WHERE (id_usuario = ? AND id_amigo = ?) OR (id_usuario = ? AND id_amigo = ?)');
    $consulta->execute(array($solicitante, $destinatario, $destinatario, $solicitante));
    $conexao->commit();
    avisar('Amizade aprovada! Agora voces podem comentar os filmes um do outro.');
} catch (Exception $e) {
    if ($conexao->inTransaction()) $conexao->rollBack();
    avisar('Nao foi possivel aprovar a amizade.');
}
redirecionar('amigos.php');
