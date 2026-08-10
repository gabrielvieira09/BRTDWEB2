<?php
    $email = $_GET['email'];
    $email = trim($email);
    $senha = $_GET['senha'];
    $senha = trim($senha);
   
    
    if($email == 'fulano@email.com' && $senha == '1234Thanos')
        echo 'Login Confirmado. Acessado';
    else
        echo 'Login Inválido. Tente novamente.';
?>