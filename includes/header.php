<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatec Itu - Gestão Empresarial</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-journal-bookmark"></i> Gestão Empresarial Fatec Itu</a>
    
    <!-- Botão Toggler para Mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMain">
      <!-- Links de Navegação -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="noticias.php"><i class="bi bi-newspaper me-1"></i> Notícias & Avisos</a>
        </li>
      </ul>

      <!-- Painel de Usuário / Login -->
      <div class="d-flex align-items-center text-white">
        <?php if(isset($_SESSION['usuario_nome'])): ?>
          <span class="me-3 small">Olá, <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong> (<?= strtoupper($_SESSION['usuario_perfil']) ?>)</span>
          <?php if(isAdmin()): ?>
              <a href="admin.php" class="btn btn-warning btn-sm me-2"><i class="bi bi-gear-fill"></i> Operador Admin</a>
          <?php endif; ?>
          <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Sair</a>
        <?php else: ?>
          <a href="login.php" class="btn btn-outline-light btn-sm"><i class="bi bi-person-lock"></i> Entrar Admin</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<div class="container pb-5">