<?php
?>
<p>Ola, <?php echo htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8'); ?>!
(<?php echo htmlspecialchars($_SESSION['tipo'], ENT_QUOTES, 'UTF-8'); ?>)</p>

<?php if ($_SESSION['tipo'] == 'consumidor') { ?>
    <a href="consumidor.php">Solicitar entrega</a> |
    <a href="minhas_solicitacoes.php">Minhas solicitacoes</a> |
<?php } elseif ($_SESSION['tipo'] == 'entregador') { ?>
    <a href="entregador.php">Entregas disponiveis</a> |
    <a href="minhas_entregas.php">Minhas entregas</a> |
<?php } elseif ($_SESSION['tipo'] == 'gerente') { ?>
    <a href="gerente.php">Painel do gerente</a> |
<?php } ?>
<a href="sair.php">Sair</a>
<hr>
