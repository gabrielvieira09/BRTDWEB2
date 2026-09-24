<?php

$emailDigitado = $_POST['email'] ?? '';
$senhaDigitada = $_POST['senha'] ?? '';

if (empty($emailDigitado) || empty($senhaDigitada)) {
    echo 'Preencha os dados corretamente';
    exit;
}

$arquivo = fopen('usuarios.txt', 'r');

$linhas = [];

while (($linha = fgets($arquivo)) !== false) 
{
    $linha = trim($linha);
    $linha = rtrim($linha, ',');

    if ($linha !== '') 
        $linhas[] = $linha;
}

fclose($arquivo);

$loginEncontrado = false;

for ($i = 0; $i < count($linhas); $i += 3) {

    if (!isset($linhas[$i], $linhas[$i + 1], $linhas[$i + 2])) 
        break;
    

    $nome = $linhas[$i];
    $email = $linhas[$i + 1];
    $senha = $linhas[$i + 2];

    if(strtolower($email) === strtolower($emailDigitado) && $senha === $senhaDigitada) {
        echo 'Olá, ' . htmlspecialchars($nome);

        ?>
        <form action="salvar.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="nome" value="<?php echo htmlspecialchars($nome); ?>">
            <br><br>
            <label>Digite seu texto:</label>
            <br>
            <textarea name="texto" rows="10" cols="50" required></textarea>
            <br><br>
            <label>Escolha uma imagem:</label>
            <br>
            <input type="file" name="imagem" accept="imagens/*"required>
            <br><br>
            <button type="submit">Publicar</button>
        </form>
        <?php
        $loginEncontrado = true;
        break;
    }
}

if (!$loginEncontrado) {
    echo 'Dados incorretos, tente novamente';
}

?>