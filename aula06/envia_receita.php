<?php
//Nome da receita
$nome = $_POST['nome'];

//Foto da receita
$nome_tmp = $_FILES["arquivoReceita"]["tmp_name"];
$destino = "imagens/" . $_FILES["arquivoReceita"]["name"];
$arquivo_receita = move_uploaded_file($nome_tmp, $destino);

//Ingredientes da receita
$ingredientes = $_POST['ingredientes'];

//Modo de preparo da receita
$modo_preparo = $_POST['modo_preparo'];

$livro_receita = fopen("receita.md", "a");

fwrite($livro_receita, "$nome\n\n");
fwrite($livro_receita, "$destino\n\n");
fwrite($livro_receita, "$ingredientes\n\n");
fwrite($livro_receita, "$modo_preparo\n\n");

echo 'Receita enviada com sucesso!'
?>

<a href="ver_receita.php">Verficar Receita</a>