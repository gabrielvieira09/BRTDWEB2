<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirLogin();
exigirPost();
$idAtual = (int)$_SESSION['id_usuario'];
$idAmigo = filter_var($_POST['id_amigo'] ?? null, FILTER_VALIDATE_INT);

$consulta = $conexao->prepare('SELECT id FROM usuarios WHERE id = ?');
$consulta->execute(array($idAmigo));
$consulta = $conexao->prepare('SELECT id FROM pendente WHERE (id_usuario = ? AND id_amigo = ?) OR (id_usuario = ? AND id_amigo = ?) LIMIT 1');
$consulta->execute(array($idAtual, $idAmigo, $idAmigo, $idAtual));
$consulta = $conexao->prepare('INSERT INTO pendente (id_usuario, id_amigo) VALUES (?, ?)');
$consulta->execute(array($idAtual, $idAmigo));
avisar('Solicitacao enviada! A pessoa precisa aprovar para virar amiga.');
redirecionar('amigos.php');
