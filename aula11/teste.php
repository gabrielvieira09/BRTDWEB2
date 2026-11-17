<?php
require_once 'funcoes.php';
require_once 'conexao.php';
header('Content-Type: text/plain; charset=utf-8');
echo "Conexao com o banco de dados: OK\n";
echo 'Usuario logado: ' . (usuarioLogado() ? $_SESSION['nome'] : 'nao') . "\n";
