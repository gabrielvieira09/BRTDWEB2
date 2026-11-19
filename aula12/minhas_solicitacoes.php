<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 'consumidor') {
    header('Location: sistema.php');
    exit;
}
require 'conexao.php';

$comando = $conexao->prepare(
    'SELECT e.*, u.nome AS nome_entregador
     FROM entregas e
     LEFT JOIN usuarios u ON e.id_entregador = u.id
     WHERE e.id_consumidor = ?
     ORDER BY e.id DESC'
);
$comando->execute([$_SESSION['id_usuario']]);
$entregas = $comando->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Minhas solicitacoes</title></head>
<body>
<?php require 'menu.php'; ?>
<h1>Minhas solicitacoes</h1>
<?php if (count($entregas) == 0) { ?>
    <p>Voce ainda nao solicitou nenhuma entrega.</p>
<?php } else { ?>
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th><th>Dimensoes (cm)</th><th>Peso (kg)</th>
        <th>Sensivel</th><th>Status</th><th>Entregador</th>
    </tr>
    <?php foreach ($entregas as $entrega) { ?>
    <tr>
        <td><?php echo mostrar($entrega['id']); ?></td>
        <td><?php echo mostrar($entrega['largura']); ?> x <?php echo mostrar($entrega['altura']); ?> x <?php echo mostrar($entrega['profundidade']); ?></td>
        <td><?php echo mostrar($entrega['peso']); ?></td>
        <td><?php echo mostrar($entrega['sensivel']); ?></td>
        <td><?php echo mostrar($entrega['status']); ?></td>
        <td><?php echo mostrar($entrega['nome_entregador'] ?? 'Aguardando'); ?></td>
    </tr>
    <?php } ?>
</table>
<?php } ?>
</body>
</html>
