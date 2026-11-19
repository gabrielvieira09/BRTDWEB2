<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de usuario</title>
</head>
<body>
<h1>Cadastro de usuario</h1>
<form action="salva_usuario.php" method="post">
    <label>Nome:</label><br>
    <input type="text" name="nome" required maxlength="100"><br><br>

    <label>E-mail:</label><br>
    <input type="email" name="email" required maxlength="150"><br><br>

    <label>Senha:</label><br>
    <input type="password" name="senha" required><br><br>

    <label>Perfil:</label><br>
    <select name="tipo" required>
        <option value="consumidor">Consumidor</option>
        <option value="entregador">Entregador</option>
    </select><br><br>

    <button type="submit">Cadastrar</button>
</form>
<p><a href="login.php">Ja tenho uma conta</a></p>
</body>
</html>
