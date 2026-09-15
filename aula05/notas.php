<?php
$nome = $_GET['nome'];
$nota1 = $_GET['nota1'];
$nota2 = $_GET['nota2'];
$nota3 = $_GET['nota3'];

$arquivo = fopen("notas.txt", "a");

fwrite($arquivo, "$nome $nota1 $nota2 $nota3\n");

echo "Nota do $nome registrada com sucesso!";

fclose($arquivo);
?>