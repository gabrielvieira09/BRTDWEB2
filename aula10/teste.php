<?php
session_start();

if(isset($_SESSION['nome'])) {
    echo $_SESSION['nome'];
} else {
?>
<a href="login.php">Fazer login</a>
<?php
}

?>