<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de usuário</title>
</head>
<body>
    <!-- $_POST[] -->
    <form action="entrada.php" method='post'>
        <label for="">E-mail:</label>
        <input type="email" name='email'><br>
        <label for="">Senha</label>
        <input type="password"  name='senha'><br>
        <input type="submit">
    </form>
</body>
</html>