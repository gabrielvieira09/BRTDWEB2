<?php
    $idade = $_GET['idade'];
    $membro = $_GET['membro'];
    $convidado = $_GET['convidado'];

    if($idade >= 18)
    {
        if($membro == 'Sim' || $convidado == 'Sim')
            echo 'Entrada permitida';
        else
            echo 'Entrada negada';
    }
    else
    {
        echo 'Entrada negada';
    }
?>