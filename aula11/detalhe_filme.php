<?php
require_once 'funcoes.php';
require_once 'conexao.php';
$idFilme = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$idFilme || $idFilme < 1) {
    http_response_code(400);
    exit('Filme invalido.');
}

$consulta = $conexao->prepare('SELECT f.*, u.nome AS autor FROM filmes f INNER JOIN usuarios u ON u.id = f.id_usuario WHERE f.id = ?');
$consulta->execute(array($idFilme));
$filme = $consulta->fetch();

$idAtual = usuarioLogado() ? (int)$_SESSION['id_usuario'] : 0;
$idAutor = (int)$filme['id_usuario'];
$ehAmigo = $idAtual > 0 && amizadeAprovada($conexao, $idAtual, $idAutor);
$ehDono = $idAtual > 0 && $idAtual === $idAutor;

$podeVerComentarios = $ehAmigo || $ehDono;
$podeComentar = $ehAmigo && !$ehDono;

$consulta = $conexao->prepare('SELECT COUNT(*) FROM curtidas WHERE id_filme = ?');
$consulta->execute(array($idFilme));
$quantidadeCurtidas = (int)$consulta->fetchColumn();
$jaCurtiu = false;
if ($idAtual) {
    $consulta = $conexao->prepare('SELECT id FROM curtidas WHERE id_filme = ? AND id_usuario = ? LIMIT 1');
    $consulta->execute(array($idFilme, $idAtual));
    $jaCurtiu = (bool)$consulta->fetch();
}

$comentarios = array();
if ($podeVerComentarios) {
    $consulta = $conexao->prepare('SELECT c.id, c.id_usuario, c.comentario, u.nome AS autor FROM comentarios c JOIN usuarios u ON u.id = c.id_usuario WHERE c.id_filme = ? ORDER BY c.id DESC');
    $consulta->execute(array($idFilme));
    $comentarios = $consulta->fetchAll();
}
?>
<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?php echo e($filme['nome']); ?> | Barrefertas</title><link rel="stylesheet" href="estilo.css"></head><body>
<?php require 'menu.php'; ?>
<main>
    <p><a href="filmes.php">← Voltar para os filmes</a></p>
    <?php exibirAviso(); ?>
    <div class="painel detalhe">
        <img src="<?php echo e(capaFilme($filme['foto'])); ?>" alt="Cartaz do filme <?php echo e($filme['nome']); ?>">
        <div>
            <h1><?php echo e($filme['nome']); ?></h1>
            <p class="meta">Cadastrado por <?php echo e($filme['autor']); ?></p>
            <p><?php echo nl2br(e($filme['descricao'])); ?></p>
            <p><strong>Classificação:</strong> <?php echo e(classificacaoTexto($filme['classificacao'])); ?></p>
            <p><strong>Nota do usuário:</strong> ⭐ <?php echo (int)$filme['nota_usuario']; ?>/10</p>
            <p><strong>Curtidas:</strong> <?php echo $quantidadeCurtidas; ?></p>
            <div class="acoes">
                <a class="botao secundario" href="<?php echo e($filme['link']); ?>" target="_blank" rel="noopener noreferrer">Abrir link do filme</a>
                <?php if ($idAtual): ?>
                    <form action="curtir_filme.php" method="post">
                        <?php echo campoCsrf(); ?>
                        <input type="hidden" name="id_filme" value="<?php echo $idFilme; ?>">
                        <button type="submit"><?php echo $jaCurtiu ? 'Descurtir' : 'Curtir'; ?></button>
                    </form>
                <?php else: ?>
                    <a href="login.php">Entre para curtir</a>
                <?php endif; ?>
            </div>
            <?php if ($ehDono): ?>
                <form action="apaga_filme.php" method="post" onsubmit="return confirm('Apagar este filme, seus comentarios e curtidas?');">
                    <?php echo campoCsrf(); ?>
                    <input type="hidden" name="id_filme" value="<?php echo $idFilme; ?>">
                    <button type="submit" class="perigo">Apagar meu filme</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <div class="painel">
        <h2>Comentários</h2>
        <?php if (!$idAtual): ?>
            <p>Você pode ver este filme. Para interagir com seus amigos, <a href="login.php">faça login</a>.</p>
        <?php elseif (!$podeVerComentarios): ?>
            <p>Os comentários ficam disponíveis apenas nos filmes dos seus amigos aprovados. <a href="amigos.php">Gerenciar amizades</a>.</p>
        <?php elseif ($podeComentar): ?>
            <p class="pequeno">Você é amigo de <?php echo e($filme['autor']); ?> e pode comentar este filme.</p>
            <form action="salva_comentario.php" method="post">
                <?php echo campoCsrf(); ?>
                <input type="hidden" name="id_filme" value="<?php echo $idFilme; ?>">
                <label for="comentario">Escreva um comentário</label>
                <textarea name="comentario" id="comentario" maxlength="100" required></textarea>
                <button type="submit">Publicar comentário</button>
            </form>
        <?php else: ?>
            <p class="pequeno">Comentários feitos por seus amigos neste filme.</p>
        <?php endif; ?>
        <?php if ($podeVerComentarios): ?>
            <h2>Últimos comentários</h2>
            <?php if (!$comentarios): ?><p>Ainda não há comentários neste filme.</p><?php endif; ?>
            <?php foreach ($comentarios as $comentario): ?>
                <div class="comentario">
                    <strong><?php echo e($comentario['autor']); ?></strong>
                    <p><?php echo nl2br(e($comentario['comentario'])); ?></p>
                    <?php if ($idAtual === (int)$comentario['id_usuario']): ?>
                        <form action="apaga_comentario.php" method="post" onsubmit="return confirm('Apagar seu comentario?');">
                            <?php echo campoCsrf(); ?>
                            <input type="hidden" name="id_comentario" value="<?php echo (int)$comentario['id']; ?>">
                            <button type="submit" class="perigo">Apagar meu comentário</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main></body></html>
