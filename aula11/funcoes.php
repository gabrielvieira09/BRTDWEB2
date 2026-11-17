<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function usuarioLogado() {
    return isset($_SESSION['id_usuario']) && (int)$_SESSION['id_usuario'] > 0;
}

function exigirLogin() {
    if (!usuarioLogado()) {
        $_SESSION['aviso'] = 'Faca login para continuar.';
        header('Location: login.php', true, 303);
        exit;
    }
}

function redirecionar($pagina) {
    header('Location: ' . $pagina, true, 303);
    exit;
}

function avisar($mensagem) {
    $_SESSION['aviso'] = $mensagem;
}

function exibirAviso() {
    if (!empty($_SESSION['aviso'])) {
        echo '<div class="aviso" role="status">' . e($_SESSION['aviso']) . '</div>';
        unset($_SESSION['aviso']);
    }
}

function tokenCsrf() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(24));
    }
    return $_SESSION['csrf'];
}

function campoCsrf() {
    return '<input type="hidden" name="csrf" value="' . e(tokenCsrf()) . '">';
}

function exigirPost() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Operacao permitida somente via POST.');
    }
    if (!isset($_POST['csrf']) || !hash_equals(tokenCsrf(), (string)$_POST['csrf'])) {
        http_response_code(403);
        exit('Sessao do formulario invalida. Recarregue a pagina e tente novamente.');
    }
}

function idadeDoNascimento($nascimento) {
    $data = DateTime::createFromFormat('!Y-m-d', (string)$nascimento);
    if (!$data || $data->format('Y-m-d') !== $nascimento) {
        return null;
    }
    $hoje = new DateTime('today');
    if ($data > $hoje) {
        return null;
    }
    return $hoje->diff($data)->y;
}

function amizadeAprovada($conexao, $idUsuario, $idAmigo) {
    if ($idUsuario === $idAmigo) {
        return false;
    }
    $consulta = $conexao->prepare('SELECT 1 FROM amigos WHERE id_usuario = ? AND id_amigo = ? LIMIT 1');
    $consulta->execute(array($idUsuario, $idAmigo));
    return (bool)$consulta->fetchColumn();
}

function classificacaoTexto($classificacao) {
    return (int)$classificacao === 0 ? 'Livre (L)' : (int)$classificacao . ' anos';
}

function capaFilme($foto)
{
    $nome = basename(str_replace('\\', '/', trim((string)$foto)));

    if (!preg_match('/\A[a-zA-Z0-9._-]+\.(?:jpg|jpeg|png|gif|webp)\z/i', $nome)) {
        return 'imagens/sem-capa.svg';
    }

    $arquivo = __DIR__ . DIRECTORY_SEPARATOR . 'imagens' . DIRECTORY_SEPARATOR . $nome;

    if (!is_file($arquivo)) {
        return 'imagens/sem-capa.svg';
    }

    return 'imagens/' . rawurlencode($nome);
}
