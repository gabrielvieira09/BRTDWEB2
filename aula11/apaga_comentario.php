<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirLogin();
exigirPost();

$consulta = $conexao->prepare('SELECT id_filme FROM comentarios WHERE id = ? AND id_usuario = ?');
$consulta->execute(array($idComentario, $_SESSION['id_usuario']));
$comentario = $consulta->fetch();

$consulta = $conexao->prepare('DELETE FROM comentarios WHERE id = ? AND id_usuario = ?');
$consulta->execute(array($idComentario, $_SESSION['id_usuario']));
avisar('Comentario apagado.');
redirecionar('detalhe_filme.php?id=' . (int)$comentario['id_filme']);
