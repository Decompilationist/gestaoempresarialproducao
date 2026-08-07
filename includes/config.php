<?php
// config.php
session_start();

$host = 'sql200.infinityfree.com';
$db   = 'if0_42602920_fatec_gestao';
$user = 'if0_42602920';
$pass = '5JBlAHHA2YtDF';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Auxiliar para checar perfil
function isAdmin() {
    return isset($_SESSION['usuario_perfil']) && $_SESSION['usuario_perfil'] === 'admin';
}
?>