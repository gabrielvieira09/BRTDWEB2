<?php
   $tipo = $_GET['tipo'];
   $tamanho = $_GET['tamanho'];

   if($tipo == 'Masculino')
    {   
        $preco = 30;
        if($tamanho == 'P')
            echo 'Preço da camiseta é: R$' . $preco-5;
        else if($tamanho == 'M')
            echo 'Preço da camiseta é: R$' . $preco+1;
        else
            echo 'Preço da camiseta é: R$' . $preco+10;
    }   
    else
    {
        $preco = 25;
        if($tamanho == 'P')
            echo 'Preço da camiseta é: R$' . $preco-5;
        else if($tamanho == 'M')
            echo 'Preço da camiseta é: R$' . $preco+1;
        else
            echo 'Preço da camiseta é: R$' . $preco+10;
    }
?>