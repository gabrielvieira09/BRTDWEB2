<?php
$livro_receita = fopen("receita.md", "r");

while(!feof($livro_receita))
{
    $text = fgets($livro_receita);
    if(str_contains($text, "imagens/"))
        echo "<img src='$text' width='300px' height='200px'>"."<br>";
    else
        echo $text . "<br>";
}

fclose($livro_receita);
?>