<?php
    $capital     = $_GET['capital'];
    $porcentagem = $_GET['porcentagem'];
    $tempo       = $_GET['tempo'];

    $jurosSimples = $capital * $porcentagem/100 * $tempo;

    echo '<b>Capital</b> - R$'. $capital;
    echo '<br><b>Taxa de Juros</b> - '. $porcentagem . '%';
    echo '<br><b>Tempo</b> - '. $tempo . ' meses';
    echo '<br><br>Juros Simples será: R$' . $jurosSimples
?>