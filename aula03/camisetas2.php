<?php
   $tipo = $_GET['tipo'];
   $tamanho = $_GET['tamanho'];
   $quantidade = $_GET['quantidade'];
   
   $desconto = $quantidade * 0.03; 

   if($tipo == 'Masculino')
    {   
        $preco = 30;
        if($tamanho == 'P')
            echo 'Preço da camiseta é: R$' . (($preco-5)* $quantidade)-((($preco-5)* $quantidade) * $desconto);
        else if($tamanho == 'M')
            echo 'Preço da camiseta é: R$' . (($preco+1)* $quantidade)-((($preco+1)* $quantidade) * $desconto);
        else
            echo 'Preço da camiseta é: R$' . (($preco+10)* $quantidade)-((($preco+10)* $quantidade) * $desconto);
    }   
    else
    {
        $preco = 25;
        if($tamanho == 'P')
            echo 'Preço da camiseta é: R$' . (($preco-5)* $quantidade)-((($preco-5)* $quantidade) * $desconto);
        else if($tamanho == 'M')
            echo 'Preço da camiseta é: R$' . (($preco+1)* $quantidade)-((($preco+1)* $quantidade) * $desconto);
        else
            echo 'Preço da camiseta é: R$' . (($preco+10)* $quantidade)-((($preco+10)* $quantidade) * $desconto);
    }
?>