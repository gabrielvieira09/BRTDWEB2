<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 'entregador') {
    header('Location: sistema.php');
    exit;
}
require 'conexao.php';

$comando = $conexao->prepare(
    "SELECT e.*, u.nome AS nome_consumidor
     FROM entregas e
     INNER JOIN usuarios u ON e.id_consumidor = u.id
     WHERE e.status = 'disponivel' AND e.id_entregador IS NULL
     ORDER BY e.id DESC"
);
$comando->execute();
$entregas = $comando->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Entregas disponiveis</title></head>
<body>
<?php require 'menu.php'; ?>
<h1>Entregas disponiveis</h1>
<?php if (count($entregas) == 0) { ?>
    <p>Nenhuma entrega disponivel no momento.</p>
<?php } else { ?>
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th><th>Consumidor</th><th>Dimensoes (cm)</th>
        <th>Peso (kg)</th><th>Conteudo sensivel?</th><th>Acao</th>
    </tr>
    <?php foreach ($entregas as $entrega) { ?>
    <tr>
        <td><?php echo mostrar($entrega['id']); ?></td>
        <td><?php echo mostrar($entrega['nome_consumidor']); ?></td>
        <td><?php echo mostrar($entrega['largura']); ?> x <?php echo mostrar($entrega['altura']); ?> x <?php echo mostrar($entrega['profundidade']); ?></td>
        <td><?php echo mostrar($entrega['peso']); ?></td>
        <td>
            <?php if ($entrega['sensivel'] == 'sim') { ?>
                <strong>ATENCAO: CONTEUDO SENSIVEL!</strong>
            <?php } else { ?>
                Nao
            <?php } ?>
        </td>
        <td>
            <form action="aceitar_entrega.php" method="post">
                <input type="hidden" name="id_entrega" value="<?php echo mostrar($entrega['id']); ?>">
                <button type="submit">Aceitar Entrega</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>
<?php } ?>
</body>
</html>
