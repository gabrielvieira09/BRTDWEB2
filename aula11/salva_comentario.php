<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirLogin();
exigirPost();

$idFilme = filter_var($_POST['id_filme'] ?? null, FILTER_VALIDATE_INT);
$comentario = trim((string)($_POST['comentario'] ?? ''));
$tamanho = function_exists('mb_strlen') ? mb_strlen($comentario, 'UTF-8') : strlen($comentario);


$consulta = $conexao->prepare('SELECT id_usuario FROM filmes WHERE id = ?');
$consulta->execute(array($idFilme));
$filme = $consulta->fetch();


$idAtual = (int)$_SESSION['id_usuario'];
$idAutor = (int)$filme['id_usuario'];


$consulta = $conexao->prepare('INSERT INTO comentarios (id_usuario, id_filme, comentario) VALUES (?, ?, ?)');
$consulta->execute(array($idAtual, $idFilme, $comentario));
avisar('Comentario enviado com sucesso.');
redirecionar('detalhe_filme.php?id=' . $idFilme);
