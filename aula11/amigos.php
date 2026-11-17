<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigirLogin();
$idAtual = (int)$_SESSION['id_usuario'];

$consulta = $conexao->prepare('SELECT u.id, u.nome, u.email FROM amigos a JOIN usuarios u ON u.id = a.id_amigo WHERE a.id_usuario = ? ORDER BY u.nome');
$consulta->execute(array($idAtual));
$amigos = $consulta->fetchAll();

$consulta = $conexao->prepare('SELECT p.id, u.nome, u.email FROM pendente p JOIN usuarios u ON u.id = p.id_usuario WHERE p.id_amigo = ? ORDER BY p.id DESC');
$consulta->execute(array($idAtual));
$recebidos = $consulta->fetchAll();

$consulta = $conexao->prepare('SELECT p.id, u.nome, u.email FROM pendente p JOIN usuarios u ON u.id = p.id_amigo WHERE p.id_usuario = ? ORDER BY p.id DESC');
$consulta->execute(array($idAtual));
$enviados = $consulta->fetchAll();

$consulta = $conexao->prepare(
    'SELECT u.id, u.nome, u.email FROM usuarios u
     WHERE u.id <> ?
       AND NOT EXISTS (SELECT 1 FROM amigos a WHERE a.id_usuario = ? AND a.id_amigo = u.id)
       AND NOT EXISTS (SELECT 1 FROM pendente p WHERE p.id_usuario = ? AND p.id_amigo = u.id)
       AND NOT EXISTS (SELECT 1 FROM pendente p WHERE p.id_amigo = ? AND p.id_usuario = u.id)
     ORDER BY u.nome'
);
$consulta->execute(array($idAtual, $idAtual, $idAtual, $idAtual));
$pessoas = $consulta->fetchAll();
?>
<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Amigos | Barrefertas</title><link rel="stylesheet" href="estilo.css"></head><body>
<?php require 'menu.php'; ?>
<main>
    <h1>Amizades</h1>
    <p class="subtitulo">Envie solicitações, aprove os pedidos recebidos e comente os filmes cadastrados pelos seus amigos.</p>
    <?php exibirAviso(); ?>

    <section class="painel"><h2>Solicitações recebidas (<?php echo count($recebidos); ?>)</h2>
        <?php if (!$recebidos): ?><p>Nenhuma solicitação aguardando aprovação.</p><?php endif; ?>
        <div class="lista-pessoas">
        <?php foreach ($recebidos as $pessoa): ?>
            <div class="pessoa"><div><strong><?php echo e($pessoa['nome']); ?></strong><div class="meta"><?php echo e($pessoa['email']); ?></div></div>
                <div class="acoes">
                    <form action="aprova_amizade.php" method="post"><?php echo campoCsrf(); ?><input type="hidden" name="id_pendente" value="<?php echo (int)$pessoa['id']; ?>"><button type="submit">Aprovar</button></form>
                    <form action="recusa_amizade.php" method="post"><?php echo campoCsrf(); ?><input type="hidden" name="id_pendente" value="<?php echo (int)$pessoa['id']; ?>"><button class="perigo" type="submit">Recusar</button></form>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </section>

    <section class="painel"><h2>Meus amigos (<?php echo count($amigos); ?>)</h2>
        <?php if (!$amigos): ?><p>Você ainda não tem amigos adicionados.</p><?php endif; ?>
        <div class="lista-pessoas">
        <?php foreach ($amigos as $pessoa): ?>
            <div class="pessoa"><div><strong><?php echo e($pessoa['nome']); ?></strong><div class="meta"><?php echo e($pessoa['email']); ?></div></div>
                <form action="desfaz_amizade.php" method="post" onsubmit="return confirm('Desfazer amizade com esta pessoa?');">
                    <?php echo campoCsrf(); ?><input type="hidden" name="id_amigo" value="<?php echo (int)$pessoa['id']; ?>"><button class="perigo" type="submit">Desfazer amizade</button>
                </form>
            </div>
        <?php endforeach; ?>
        </div>
    </section>

    <section class="painel"><h2>Solicitações enviadas (<?php echo count($enviados); ?>)</h2>
        <?php if (!$enviados): ?><p>Nenhum pedido aguardando resposta.</p><?php endif; ?>
        <div class="lista-pessoas">
        <?php foreach ($enviados as $pessoa): ?>
            <div class="pessoa"><div><strong><?php echo e($pessoa['nome']); ?></strong><div class="meta">Aguardando aprovação · <?php echo e($pessoa['email']); ?></div></div>
                <form action="cancela_solicitacao.php" method="post">
                    <?php echo campoCsrf(); ?><input type="hidden" name="id_pendente" value="<?php echo (int)$pessoa['id']; ?>"><button class="secundario" type="submit">Cancelar solicitação</button>
                </form>
            </div>
        <?php endforeach; ?>
        </div>
    </section>

    <section class="painel"><h2>Conhecer pessoas</h2>
        <?php if (!$pessoas): ?><p>Não há novas pessoas disponíveis para adicionar agora.</p><?php endif; ?>
        <div class="lista-pessoas">
        <?php foreach ($pessoas as $pessoa): ?>
            <div class="pessoa"><div><strong><?php echo e($pessoa['nome']); ?></strong><div class="meta"><?php echo e($pessoa['email']); ?></div></div>
                <form action="solicita_amizade.php" method="post">
                    <?php echo campoCsrf(); ?><input type="hidden" name="id_amigo" value="<?php echo (int)$pessoa['id']; ?>"><button type="submit">Solicitar amizade</button>
                </form>
            </div>
        <?php endforeach; ?>
        </div>
    </section>
</main></body></html>
