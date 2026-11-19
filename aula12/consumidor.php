<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 'consumidor') {
    header('Location: sistema.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Solicitar entrega</title></head>
<body>
<?php require 'menu.php'; ?>
<h1>Solicitar entrega</h1>
<form action="salva_entrega.php" method="post">
    <label>Largura (cm):</label><br>
    <input type="number" name="largura" min="0.01" max="99999999" step="0.01" required><br><br>

    <label>Altura (cm):</label><br>
    <input type="number" name="altura" min="0.01" max="99999999" step="0.01" required><br><br>

    <label>Profundidade (cm):</label><br>
    <input type="number" name="profundidade" min="0.01" max="99999999" step="0.01" required><br><br>

    <label>Peso (kg):</label><br>
    <input type="number" name="peso" min="0.01" max="99999999" step="0.01" required><br><br>

    <label>Conteudo sensivel?</label><br>
    <select name="sensivel" required>
        <option value="nao">Nao</option>
        <option value="sim">Sim</option>
    </select><br><br>

    <button type="submit">Solicitar entrega</button>
</form>
</body>
</html>
