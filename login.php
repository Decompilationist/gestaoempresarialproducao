<?php
// login.php
require_once __DIR__ . '/includes/config.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nome'] = $user['nome'];
        $_SESSION['usuario_perfil'] = $user['perfil'];
        header("Location: index.php");
        exit;
    } else {
        $mensagem = "Credenciais inválidas!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Gestão Fatec Itu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">
<div class="container" style="max-width: 400px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">Fatec Itu - Gestão</h4>
            <?php if($mensagem): ?>
                <div class="alert alert-danger"><?= $mensagem ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
            <div class="text-center mt-3">
                <a href="index.php" class="text-secondary small">Voltar para o Painel Geral</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>