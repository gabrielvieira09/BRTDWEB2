<?php
$data = $_GET['data'];
$texto = $_GET['texto'];

$arquivo = fopen("diario.md", "a");

fwrite($arquivo, "$data\n");
fwrite($arquivo, "$texto\n");

echo "Escrita de hoje registrada com sucesso!";

fclose($arquivo);
?>