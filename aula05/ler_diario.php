<?php
$arquivo = fopen("diario.md", "r");

while(!feof($arquivo))
{
    $text = fgets($arquivo);
    echo $text . "<br>";
}

fclose($arquivo);
?>