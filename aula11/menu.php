<?php
if (usuarioLogado()) {
    require_once __DIR__ . '/conexao.php';

    $consultaIdade = $conexao->prepare('SELECT nascimento FROM usuarios WHERE id = ? LIMIT 1');
    $consultaIdade->execute(array((int)$_SESSION['id_usuario']));
    $nascimento = $consultaIdade->fetchColumn();
    $idadeAtual = ($nascimento === false) ? null : idadeDoNascimento((string)$nascimento);

    if ($idadeAtual !== null) {
        $_SESSION['idade'] = $idadeAtual;
    }
}
?>
<header class="cabecalho">
    <div class="barra">
        <nav aria-label="Menu principal">
            <a href="filmes.php">Filmes</a><br>
            <?php if (usuarioLogado()): ?>
                <a href="novo_filme.php">Cadastrar filme</a><br>
                <a href="amigos.php">Amigos</a><br>
                <span class="usuario">Olá, <?php echo e($_SESSION['nome']); ?> (<?php echo (int)$_SESSION['idade']; ?> anos)</span>
                <a href="sair.php">Sair</a><br>
            <?php else: ?>
                <a href="login.php">Entrar</a>
                <a href="cadastro.php">Cadastrar</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
