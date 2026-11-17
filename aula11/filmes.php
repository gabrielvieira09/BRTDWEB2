<?php
require_once 'funcoes.php';
require_once 'conexao.php';

// Qualquer visitante pode ver os filmes cadastrados.
$consulta = $conexao->query(
    'SELECT f.id, f.nome, f.descricao, f.foto, f.classificacao, f.nota_usuario,
            u.nome AS autor,
            (SELECT COUNT(*) FROM curtidas c WHERE c.id_filme = f.id) AS quantidade_curtidas
     FROM filmes f INNER JOIN usuarios u ON u.id = f.id_usuario ORDER BY f.id DESC'
);
$filmes = $consulta->fetchAll();
?>
<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Filmes | Barrefertas</title><link rel="stylesheet" href="estilo.css"></head><body>
<?php require 'menu.php'; ?>
<main>
    <h1>Filmes cadastrados</h1>
    <p class="subtitulo">Clique na imagem ou em “Ver detalhes” para conhecer o filme, conferir as curtidas e os comentários.</p>
    <?php exibirAviso(); ?>
    <?php if (usuarioLogado()): ?><p><a class="botao" href="novo_filme.php">+ Cadastrar novo filme</a></p><?php endif; ?>
    <?php if (!$filmes): ?><div class="painel">Nenhum filme cadastrado ainda. <a href="novo_filme.php">Cadastre o primeiro filme</a>.</div><?php endif; ?>
    <div class="grade">
    <?php foreach ($filmes as $filme): ?>
        <article class="cartao">
            <a href="detalhe_filme.php?id=<?php echo (int)$filme['id']; ?>"><img src="<?php echo e(capaFilme($filme['foto'])); ?>" alt="Capa do filme <?php echo e($filme['nome']); ?>"></a>
            <div class="conteudo">
                <h2><?php echo e($filme['nome']); ?></h2>
                <p class="meta">Por <?php echo e($filme['autor']); ?> · <?php echo e(classificacaoTexto($filme['classificacao'])); ?></p>
                <p>Nota do usuário: <?php echo (int)$filme['nota_usuario']; ?>/10</p>
                <p><?php echo (int)$filme['quantidade_curtidas']; ?> curtida(s)</p>
                <a class="botao" href="detalhe_filme.php?id=<?php echo (int)$filme['id']; ?>">Ver detalhes</a>
            </div>
        </article>
    <?php endforeach; ?>
    </div>
</main></body></html>
