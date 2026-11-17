<?php
require_once 'funcoes.php';
if (usuarioLogado()) redirecionar('filmes.php');
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Criar conta | Barrefertas</title><link rel="stylesheet" href="estilo.css"></head>
<body>
<?php require 'menu.php'; ?>
<main>
    <h1>Cadastro de usuário</h1>
    <p class="subtitulo">Informe seus dados para sugerir filmes e adicionar amigos.</p>
    <?php exibirAviso(); ?>
    <div class="painel">
    <form action="salva_usuario.php" method="post">
        <?php echo campoCsrf(); ?>
        <label for="nome">Nome</label><input type="text" id="nome" name="nome" maxlength="200" required>
        <label for="email">E-mail</label><input type="email" id="email" name="email" maxlength="200" required>
        <label for="nascimento">Data de nascimento</label><input type="date" id="nascimento" name="nascimento" max="<?php echo date('Y-m-d'); ?>" required>
        <label for="senha">Senha</label><input type="password" id="senha" name="senha" minlength="6" required>
        <button type="submit">Cadastrar</button>
    </form>
    <p>Já tem conta? <a href="login.php">Faça login</a>.</p>
    </div>
</main></body></html>
