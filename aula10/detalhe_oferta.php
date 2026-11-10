<?php
require('conexao.php');
session_start();

$id_oferta = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_oferta || $id_oferta < 1) {
    http_response_code(400);
    exit('Oferta inválida.');
}

$stm = $conexao->prepare('SELECT * FROM ofertas WHERE id = ?');
$stm->execute(array($id_oferta));
$oferta = $stm->fetch(PDO::FETCH_ASSOC);
if (!$oferta) {
    http_response_code(404);
    exit('Oferta não encontrada.');
}
function escapar($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}

$stm = $conexao->prepare('SELECT c.id, c.id_usuario, c.comentario, c.criado_em, u.nome AS autor
                         FROM comentarios c
                         INNER JOIN usuarios u ON u.id = c.id_usuario
                         WHERE c.id_oferta = ?
                         ORDER BY c.criado_em DESC, c.id DESC');
$stm->execute(array($id_oferta));
$comentarios = $stm->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Detalhes da oferta</title></head>
<body>
<a href="ofertas.php">Voltar às ofertas</a>
<h1><?php echo escapar($oferta['nome']); ?></h1>
<img src="<?php echo escapar($oferta['foto']); ?>" height="100" alt="Foto da oferta">
<p><?php echo nl2br(escapar($oferta['descricao'])); ?></p>
<h3><?php echo escapar($oferta['preco']); ?></h3>
<a href="<?php echo escapar($oferta['link']); ?>">Comprar</a>

<?php if (isset($_SESSION['id']) && (int)$_SESSION['id'] === (int)$oferta['id_usuario']): ?>
    <form action="apaga_oferta.php" method="post" onsubmit="return confirm('Deseja excluir esta oferta e seus comentários?');">
        <input type="hidden" name="id_oferta" value="<?php echo $id_oferta; ?>">
        <button type="submit">Apagar minha oferta</button>
    </form>
<?php endif; ?>

<hr>
<h2>Comentários</h2>
<?php if (isset($_SESSION['id'])): ?>
    <form action="salva_comentario.php" method="post">
        <input type="hidden" name="id_oferta" value="<?php echo $id_oferta; ?>">
        <textarea name="comentario" maxlength="2000" required placeholder="Escreva seu comentário"></textarea>
        <button type="submit">Comentar</button>
    </form>
<?php else: ?>
    <p><a href="login.php">Faça login</a> para comentar.</p>
<?php endif; ?>

<?php if (!$comentarios): ?>
    <p>Esta oferta ainda não tem comentários.</p>
<?php endif; ?>

<?php foreach ($comentarios as $comentario): ?>
    <div>
        <strong><?php echo escapar($comentario['autor']); ?></strong>
        <small><?php echo escapar($comentario['criado_em']); ?></small>
        <p><?php echo nl2br(escapar($comentario['comentario'])); ?></p>
        <?php if (isset($_SESSION['id']) && (int)$_SESSION['id'] === (int)$comentario['id_usuario']): ?>
            <form action="apaga_comentario.php" method="post" onsubmit="return confirm('Apagar este comentário?');">
                <input type="hidden" name="id_comentario" value="<?php echo (int)$comentario['id']; ?>">
                <button type="submit">Apagar comentário</button>
            </form>
        <?php endif; ?>
    </div>
    <hr>
<?php endforeach; ?>
</body>
</html>
