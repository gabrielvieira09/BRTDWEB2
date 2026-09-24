<?php
$nome = $_POST['nome'] ?? '';
$texto = $_POST['texto'] ?? '';

$nomeImagem = '';

if (isset($_FILES['imagem'])) 
{
    $nomeImagem = basename($_FILES['imagem']['name']);
    move_uploaded_file($_FILES['imagem']['tmp_name'],'imagens/' . $nomeImagem);
}

$arquivo = $nome . '.txt';

$conteudo =  $texto . "\n";
$conteudo  .= $nomeImagem . "\n";

$arquivoAberto = fopen($arquivo, 'a');

fwrite($arquivoAberto, $conteudo);

fclose($arquivoAberto);

echo 'Publicação salva com sucesso!';

?>