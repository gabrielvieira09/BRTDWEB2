<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirLogin();
exigirPost();
$idAtual = (int)$_SESSION['id_usuario'];
$idAmigo = filter_var($_POST['id_amigo'] ?? null, FILTER_VALIDATE_INT);

$consulta = $conexao->prepare('DELETE FROM amigos WHERE (id_usuario = ? AND id_amigo = ?) OR (id_usuario = ? AND id_amigo = ?)');
$consulta->execute(array($idAtual, $idAmigo, $idAmigo, $idAtual));
avisar('Amizade desfeita.');
redirecionar('amigos.php');
