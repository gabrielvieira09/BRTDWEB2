<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirLogin();
exigirPost();

$idFilme = filter_var($_POST['id_filme'] ?? null, FILTER_VALIDATE_INT);

$consulta = $conexao->prepare('SELECT id FROM filmes WHERE id = ?');
$consulta->execute(array($idFilme));

$idAtual = (int)$_SESSION['id_usuario'];
$consulta = $conexao->prepare('SELECT id FROM curtidas WHERE id_filme = ? AND id_usuario = ? LIMIT 1');
$consulta->execute(array($idFilme, $idAtual));
$curtida = $consulta->fetch();
if ($curtida) {
    $consulta = $conexao->prepare('DELETE FROM curtidas WHERE id_filme = ? AND id_usuario = ?');
    $consulta->execute(array($idFilme, $idAtual));
    avisar('Voce removeu sua curtida.');
} else {
    $consulta = $conexao->prepare('INSERT INTO curtidas (id_usuario, id_filme) VALUES (?, ?)');
    $consulta->execute(array($idAtual, $idFilme));
    avisar('Filme curtido!');
}
redirecionar('detalhe_filme.php?id=' . $idFilme);
