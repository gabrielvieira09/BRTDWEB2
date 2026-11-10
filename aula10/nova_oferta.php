<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de usuário</title>
</head>
<body>
    <!-- $_POST[] -->
    <form action="salva_oferta.php" method='post' enctype='multipart/form-data'>
        <label for="">Nome da oferta:</label>
        <input type="text" name='nome'><br>
        <label for="">Descrição:</label>
        <input type="text" name='desc'><br>
        <label for="">Foto:</label>
        <input type="file" name='foto'><br>
        <label for="">Link:</label>
        <input type="text" name='link'><br>
        <label for="">Valor:</label>
        <input type="text" name='valor'><br>
        <input type="submit">
    </form>
</body>
</html>