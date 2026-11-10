<?php
echo "<h1>Ofertas disponíveis</h1>";
echo "<p>Clique na imagem de uma oferta para visualizar os detalhes e comentários.</p>";

require('conexao.php');

$comando = "SELECT `id`, `foto`, `preco` FROM `ofertas` ORDER BY `id` DESC";

$stm = $conexao->prepare($comando);
$stm->execute();

while($resultado = $stm->fetch(PDO::FETCH_ASSOC)) {
    echo "<a href=\"detalhe_oferta.php?id={$resultado['id']}\"><img src='{$resultado['foto']}' height='100px'></a>";
    echo "<br><h2>";
    echo $resultado['preco'];
    echo "</h2><br>";
}


?>
