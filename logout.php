<?php
// logout.php
require_once __DIR__ . '/includes/config.php';

// Inicia/recupera a sessão atual para poder destruí-la
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Destrói o cookie da sessão, se existir
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão por completo
session_destroy();

// Redireciona para o login ou página inicial
header("Location: login.php");
exit;
?>