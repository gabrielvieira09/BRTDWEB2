<?php
    $veiculo = $_GET['veiculo'];
    $pista = $_GET['pista'];

    if($veiculo > $pista)
        echo 'Gerar multa';
    else
        echo 'Direção segura';
?>