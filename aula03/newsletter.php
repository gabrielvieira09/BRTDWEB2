<?php
    $email = $_GET['email'];

    if(isset($_GET['noticias']) || isset($_GET['promocoes']))
        echo 'Você do email - ' .$email. ' - quer receber notícias e/ou promoções. Assinatura Confirmada!';
    else
        echo 'Você do email - ' .$email. ' - não quer receber notícias e/ou promoções. Assinatura Recusada!';
?>