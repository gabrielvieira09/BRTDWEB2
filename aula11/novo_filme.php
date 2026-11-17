<?php
require_once 'funcoes.php';
exigirLogin();
$classificacoes = array(0, 10, 12, 14, 16, 18);
?>
<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Cadastrar filme | Barrefertas</title><link rel="stylesheet" href="estilo.css"></head><body>
<?php require 'menu.php'; ?>
<main><h1>Cadastrar filme</h1><p class="subtitulo">Sua idade é <?php echo (int)$_SESSION['idade']; ?> anos. Você só pode cadastrar filmes cuja classificação indicativa não ultrapasse sua idade.</p>
<?php exibirAviso(); ?>
<div class="painel">
<form action="salva_filme.php" method="post" enctype="multipart/form-data">
    <?php echo campoCsrf(); ?>
    <label for="nome">Nome do filme</label><input type="text" name="nome" id="nome" maxlength="200" required><br><br>
    <label for="descricao">Descrição</label><textarea name="descricao" id="descricao" maxlength="300" required></textarea><br><br>
    <label for="foto">Foto / cartaz do filme </label><input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/gif,image/webp" required><br><br>
    <label for="link">Link do filme ou trailer</label><input type="url" name="link" id="link" maxlength="200" placeholder="https://..." required><br><br>
    <label for="classificacao">Classificação indicativa</label>
    <select name="classificacao" id="classificacao" required>
        <?php foreach ($classificacoes as $valor): ?>
            <option value="<?php echo $valor; ?>" <?php echo $valor > (int)$_SESSION['idade'] ? 'disabled' : ''; ?>><?php echo e(classificacaoTexto($valor)); ?><?php echo $valor > (int)$_SESSION['idade'] ? ' (não permitida para sua idade)' : ''; ?></option>
        <?php endforeach; ?>
    </select><br><br>
    <label for="nota_usuario">Sua nota para o filme (0 a 10)</label><input type="number" name="nota_usuario" id="nota_usuario" min="0" max="10" value="10" required><br><br>
    <button type="submit">Salvar filme</button>
</form>
</div></main></body></html>
