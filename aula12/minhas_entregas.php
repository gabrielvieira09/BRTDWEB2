<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 'entregador') {
    header('Location: sistema.php');
    exit;
}
require 'conexao.php';

$comando = $conexao->prepare(
    'SELECT e.*, u.nome AS nome_consumidor
     FROM entregas e
     INNER JOIN usuarios u ON e.id_consumidor = u.id
     WHERE e.id_entregador = ?
     ORDER BY e.id DESC'
);
$comando->execute([$_SESSION['id_usuario']]);
$entregas = $comando->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Minhas entregas</title></head>
<body>
<?php require 'menu.php'; ?>
<h1>Minhas entregas</h1>
<?php if (count($entregas) == 0) { ?>
    <p>Voce ainda nao aceitou nenhuma entrega.</p>
<?php } else { ?>
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th><th>Consumidor</th><th>Dimensoes (cm)</th>
        <th>Peso (kg)</th><th>Sensivel</th><th>Status</th><th>Acao</th>
    </tr>
    <?php foreach ($entregas as $entrega) { ?>
    <tr>
        <td><?php echo mostrar($entrega['id']); ?></td>
        <td><?php echo mostrar($entrega['nome_consumidor']); ?></td>
        <td><?php echo mostrar($entrega['largura']); ?> x <?php echo mostrar($entrega['altura']); ?> x <?php echo mostrar($entrega['profundidade']); ?></td>
        <td><?php echo mostrar($entrega['peso']); ?></td>
        <td>
            <?php if ($entrega['sensivel'] == 'sim') { ?>
                <strong>ATENCAO: SENSIVEL!</strong>
            <?php } else { ?>Nao<?php } ?>
        </td>
        <td><?php echo mostrar($entrega['status']); ?></td>
        <td>
            <?php if ($entrega['status'] == 'em_rota') { ?>
            <form action="marcar_entregue.php" method="post">
                <input type="hidden" name="id_entrega" value="<?php echo mostrar($entrega['id']); ?>">
                <button type="submit">Marcar como entregue</button>
            </form>
            <?php } else { ?>
                Sem acao
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
<?php } ?>
</body>
</html>
