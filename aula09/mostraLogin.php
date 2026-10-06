<?php
session_start();

if(isset($_SESSION['nome']))
    echo 'Olá, ' . $_SESSION['nome'];
else
    echo 'Acesse a página de login: <a href="site.html">Página de Login</a>'
?>