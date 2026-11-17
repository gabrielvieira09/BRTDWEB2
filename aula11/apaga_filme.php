<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirLogin();
exigirPost();
$idFilme = filter_var($_POST['id_filme'] ?? null, FILTER_VALIDATE_INT);

try {
    $conexao->beginTransaction();
    $consulta = $conexao->prepare('SELECT foto FROM filmes WHERE id = ? AND id_usuario = ? FOR UPDATE');
    $consulta->execute(array($idFilme, $_SESSION['id_usuario']));
    $filme = $consulta->fetch();
    if (!$filme) {
        $conexao->rollBack();
        erroComRetorno('Filme nao encontrado ou nao pertence a voce.', 'filmes.php');
    }
    $consulta = $conexao->prepare('DELETE FROM comentarios WHERE id_filme = ?');
    $consulta->execute(array($idFilme));
    $consulta = $conexao->prepare('DELETE FROM curtidas WHERE id_filme = ?');
    $consulta->execute(array($idFilme));
    $consulta = $conexao->prepare('DELETE FROM filmes WHERE id = ? AND id_usuario = ?');
    $consulta->execute(array($idFilme, $_SESSION['id_usuario']));
    $conexao->commit();

    $foto = (string)$filme['foto'];
    if (strpos($foto, 'imagens/') === 0 && basename($foto) === substr($foto, 8)) {
        $caminho = __DIR__ . DIRECTORY_SEPARATOR . $foto;
        if (is_file($caminho)) @unlink($caminho);
    }
} catch (Exception $e) {
    if ($conexao->inTransaction()) $conexao->rollBack();
    avisar('Nao foi possivel apagar o filme.');
}
redirecionar('filmes.php');
