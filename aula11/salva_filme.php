<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirLogin();
exigirPost();

$nome = trim((string)($_POST['nome'] ?? ''));
$descricao = trim((string)($_POST['descricao'] ?? ''));
$link = trim((string)($_POST['link'] ?? ''));
$classificacao = filter_var($_POST['classificacao'] ?? null, FILTER_VALIDATE_INT);
$notaUsuario = filter_var($_POST['nota_usuario'] ?? null, FILTER_VALIDATE_INT);


$consulta = $conexao->prepare('SELECT nascimento FROM usuarios WHERE id = ?');
$consulta->execute(array($_SESSION['id_usuario']));
$usuario = $consulta->fetch();
$idade = $usuario ? idadeDoNascimento($usuario['nascimento']) : null;

$_SESSION['idade'] = $idade;


$finfo = new finfo(FILEINFO_MIME_TYPE);
$tipo = $finfo->file($_FILES['foto']['tmp_name']);
$tipos = array('image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp');

$pasta = __DIR__ . DIRECTORY_SEPARATOR . 'imagens';

$nomeArquivo = bin2hex(random_bytes(12)) . '.' . $tipos[$tipo];
$destino = $pasta . DIRECTORY_SEPARATOR . $nomeArquivo;

$foto = 'imagens/' . $nomeArquivo;
try {
    $consulta = $conexao->prepare('INSERT INTO filmes (id_usuario, nome, descricao, foto, link, classificacao, nota_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $consulta->execute(array($_SESSION['id_usuario'], $nome, $descricao, $foto, $link, $classificacao, $notaUsuario));
    $idFilme = (int)$conexao->lastInsertId();
} catch (PDOException $e) {
    @unlink($destino);
    erroComRetorno('Nao foi possivel salvar o filme no banco.', 'novo_filme.php');
}

avisar('Filme cadastrado com sucesso! Confira os detalhes abaixo.');
redirecionar('detalhe_filme.php?id=' . $idFilme);
