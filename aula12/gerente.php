<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 'gerente') {
    header('Location: sistema.php');
    exit;
}
require 'conexao.php';

// O gerente pode filtrar por status ou ver tudo.
$filtro = $_GET['status'] ?? 'todos';
$statusPermitidos = ['todos', 'disponivel', 'em_rota', 'entregue', 'cancelado'];
if (!in_array($filtro, $statusPermitidos)) {
    $filtro = 'todos';
}

$sql = 'SELECT e.*, c.nome AS nome_consumidor, d.nome AS nome_entregador
        FROM entregas e
        INNER JOIN usuarios c ON e.id_consumidor = c.id
        LEFT JOIN usuarios d ON e.id_entregador = d.id';

if ($filtro != 'todos') {
    $sql .= ' WHERE e.status = ?';
}
$sql .= ' ORDER BY e.id DESC';

$comando = $conexao->prepare($sql);
if ($filtro == 'todos') {
    $comando->execute();
} else {
    $comando->execute([$filtro]);
}
$entregas = $comando->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Painel do gerente</title></head>
<body>
<?php require 'menu.php'; ?>
<h1>Painel do gerente</h1>

<form action="gerente.php" method="get">
    <label>Filtrar por status:</label>
    <select name="status">
        <option value="todos" <?php if ($filtro == 'todos') echo 'selected'; ?>>Todos</option>
        <option value="disponivel" <?php if ($filtro == 'disponivel') echo 'selected'; ?>>Disponivel</option>
        <option value="em_rota" <?php if ($filtro == 'em_rota') echo 'selected'; ?>>Em rota</option>
        <option value="entregue" <?php if ($filtro == 'entregue') echo 'selected'; ?>>Entregue</option>
        <option value="cancelado" <?php if ($filtro == 'cancelado') echo 'selected'; ?>>Cancelado</option>
    </select>
    <button type="submit">Filtrar</button>
</form>

<p>Total de entregas neste filtro: <?php echo count($entregas); ?></p>
<?php if (count($entregas) == 0) { ?>
    <p>Nenhuma entrega encontrada.</p>
<?php } else { ?>
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th><th>Consumidor</th><th>Entregador</th>
        <th>Dimensoes (cm)</th><th>Peso (kg)</th><th>Sensivel</th>
        <th>Status</th><th>Acoes</th>
    </tr>
    <?php foreach ($entregas as $entrega) { ?>
    <tr>
        <td><?php echo mostrar($entrega['id']); ?></td>
        <td><?php echo mostrar($entrega['nome_consumidor']); ?></td>
        <td><?php echo mostrar($entrega['nome_entregador'] ?? 'Aguardando'); ?></td>
        <td><?php echo mostrar($entrega['largura']); ?> x <?php echo mostrar($entrega['altura']); ?> x <?php echo mostrar($entrega['profundidade']); ?></td>
        <td><?php echo mostrar($entrega['peso']); ?></td>
        <td><?php echo $entrega['sensivel'] == 'sim' ? 'ATENCAO: SENSIVEL' : 'Nao'; ?></td>
        <td><?php echo mostrar($entrega['status']); ?></td>
        <td>
            <?php if ($entrega['status'] == 'disponivel' || $entrega['status'] == 'em_rota') { ?>
            <form action="cancelar_entrega.php" method="post">
                <input type="hidden" name="id_entrega" value="<?php echo mostrar($entrega['id']); ?>">
                <button type="submit">Cancelar</button>
            </form>
            <?php } ?>
            <form action="excluir_entrega.php" method="post" onsubmit="return confirm('Excluir esta entrega?');">
                <input type="hidden" name="id_entrega" value="<?php echo mostrar($entrega['id']); ?>">
                <button type="submit">Excluir</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>
<?php } ?>
</body>
</html>
