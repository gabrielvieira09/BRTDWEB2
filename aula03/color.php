<?php
    $texto = $_GET['texto'];
    $corTexto = $_GET['cor_texto'];
    $corFundo = $_GET['cor_fundo'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color: <?php echo $corFundo; ?>;
            color: <?php echo $corTexto; ?>;
        }
    </style>
</head>
<body>
    <h1> <?php  echo $texto; ?></h1>
</body>
</html>