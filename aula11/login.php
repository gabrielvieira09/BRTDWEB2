<?php
require_once 'funcoes.php';
if (usuarioLogado()) redirecionar('filmes.php');
?>
<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Entrar | Barrefertas</title><link rel="stylesheet" href="estilo.css"></head><body>
<?php require 'menu.php'; ?>
<main><h1>Entrar</h1><p class="subtitulo">Acesse para cadastrar filmes, enviar pedidos de amizade, comentar e curtir.</p>
<?php exibirAviso(); ?>
<div class="painel"><form action="entrada.php" method="post">
    <?php echo campoCsrf(); ?>
    <label for="email">E-mail</label><input id="email" type="email" name="email" required>
    <label for="senha">Senha</label><input id="senha" type="password" name="senha" required>
    <button type="submit">Fazer login</button>
</form><p>Não tem conta? <a href="cadastro.php">Cadastre-se</a>.</p></div>
</main></body></html>
