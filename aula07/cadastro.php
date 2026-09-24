<?php
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

if(empty($nome) || empty($email) || empty($senha))
{
    echo 'Preencha os dados corretamente';
}
else
{
    $dados =  $nome. ', \n' . $email . ', \n' . $senha . ', \n';
        
    $arquivo = fopen("usuarios.txt", "a");

    fwrite($arquivo, $dados);

    fclose($arquivo);
        
    echo 'Dados salvos com sucesso';
}
?>