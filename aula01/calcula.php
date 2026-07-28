<?php
    $valor = $_GET['valor'];
    echo "Preço: $valor";

    $quantidade = $_GET['quantidade'];
    echo "<br>Quantidade: $quantidade";

    $total = $valor*$quantidade;
    echo "<br><br>Total: $total";
?>