<?php
require('conexao.php');

session_start();

$nome_original = $_FILES['foto']['name'];
$nome_tmp = $_FILES['foto']['tmp_name'];
$destino = "imagens/$nome_original";

if(isset($_SESSION['id'])) {
    move_uploaded_file($nome_tmp, $destino);

    $id = $_SESSION['id'];
    $n = $_POST['nome'];
    $d = $_POST['desc'];
    $f = "$destino";
    $l = $_POST['link'];
    $v = $_POST['valor'];

    $comando = "INSERT INTO `ofertas` (`id`, `id_usuario`, `nome`, `descricao`, `foto`, `link`, `preco`) VALUES (NULL, '$id', '$n', '$d', '$f', '$l', '$v')";

    $linhas = $conexao->exec($comando);

    if($linhas > 0) {
        echo "Oferta foi cadastrada com sucesso!";
    } else {
        echo "Erro no cadastro da oferta.";
    }
} else {
    ?>
<a href="login.php">Fazer login</a>
<?php
}
?>