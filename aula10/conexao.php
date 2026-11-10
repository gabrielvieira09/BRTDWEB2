<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "barrefertas";
$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
?>