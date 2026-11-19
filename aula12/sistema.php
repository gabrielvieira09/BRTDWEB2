<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['tipo'] == 'consumidor') {
    header('Location: consumidor.php');
} elseif ($_SESSION['tipo'] == 'entregador') {
    header('Location: entregador.php');
} elseif ($_SESSION['tipo'] == 'gerente') {
    header('Location: gerente.php');
} else {
    header('Location: sair.php');
}
exit;
