<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirLogin();
exigirPost();
$idPendente = filter_var($_POST['id_pendente'] ?? null, FILTER_VALIDATE_INT);
$consulta = $conexao->prepare('DELETE FROM pendente WHERE id = ? AND id_amigo = ?');
$consulta->execute(array($idPendente, $_SESSION['id_usuario']));
avisar($consulta->rowCount() ? 'Solicitacao recusada.' : 'Pedido nao encontrado.');
redirecionar('amigos.php');
