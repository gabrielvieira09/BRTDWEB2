<?php
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'barrefertas';

try {
    $conexao = new PDO(
        "mysql:host=$servidor;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
              PDO::ATTR_EMULATE_PREPARES => false)
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Nao foi possivel conectar ao banco de dados. Confira o arquivo conexao.php e importe o SQL.');
}
