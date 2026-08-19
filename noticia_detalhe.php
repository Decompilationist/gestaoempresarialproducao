<?php
require_once __DIR__ . '/includes/config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: noticias.php");
    exit;
}

// Converter URLs em botões
function converterLinksEmBotoes($texto) {
    $pattern = '/https?:\/\/[^\s<]+/';
    return preg_replace_callback($pattern, function($matches) {
        $url = htmlspecialchars($matches[0]);
        return '<br><a href="' . $url . '" target="_blank" rel="noopener noreferrer" class="btn btn-primary mt-2"><i class="bi bi-box-arrow-up-right"></i> Abrir Link / Documento Relacionado</a>';
    }, nl2br(htmlspecialchars($texto)));
}

function getBadgeColor($tipo) {
    return match (strtolower($tipo)) {
        'aviso institucional', 'aviso' => 'bg-danger',
        'estágio/vaga', 'vaga' => 'bg-success',
        'evento' => 'bg-warning text-dark',
        default => 'bg-primary',
    };
}

try {
    $sql = "
        SELECT n.*, u.nome AS autor 
        FROM noticias_eventos n 
        LEFT JOIN usuarios u ON n.usuario_id = u.id 
        WHERE n.id = :id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $noticia = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$noticia) {
        header("Location: noticias.php");
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao buscar a notícia.");
}

$pageUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($noticia['titulo']) ?> - Portal Fatec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-body-tertiary">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <a href="noticias.php" class="btn btn-outline-secondary btn-sm mb-4">
                <i class="bi bi-arrow-left me-1"></i> Voltar para o Portal
            </a>

            <article class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <?php if (!empty($noticia['imagem_capa']) && file_exists('uploads/' . $noticia['imagem_capa'])): ?>
                    <div class="ratio ratio-21x9">
                        <img src="uploads/<?= htmlspecialchars($noticia['imagem_capa']) ?>" class="object-fit-cover" alt="Capa">
                    </div>
                <?php endif; ?>

                <div class="card-body p-4 p-md-5">
                    
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge <?= getBadgeColor($noticia['tipo']) ?> px-3 py-2 fs-6"><?= htmlspecialchars($noticia['tipo']) ?></span>
                        <?php if ($noticia['fixado']): ?>
                            <span class="badge bg-warning text-dark px-3 py-2 fs-6"><i class="bi bi-pin-angle-fill"></i> Destaque</span>
                        <?php endif; ?>
                    </div>

                    <h1 class="fw-bold text-dark mb-2"><?= htmlspecialchars($noticia['titulo']) ?></h1>

                    <?php if (!empty($noticia['subtitulo'])): ?>
                        <h4 class="text-secondary fw-normal mb-4"><?= htmlspecialchars($noticia['subtitulo']) ?></h4>
                    <?php endif; ?>

                    <div class="d-flex flex-wrap justify-content-between align-items-center border-top border-bottom py-3 mb-4 text-muted small">
                        <div>
                            <i class="bi bi-person-circle me-1"></i> Publicado por: <strong><?= htmlspecialchars($noticia['autor'] ?? 'Administração') ?></strong>
                        </div>
                        <div>
                            <i class="bi bi-calendar3 me-1"></i> <?= date('d/m/Y \à\s H:i', strtotime($noticia['created_at'])) ?>
                        </div>
                    </div>

                    <?php if (!empty($noticia['data_evento'])): ?>
                        <div class="alert alert-info border-0 d-flex align-items-center gap-3 p-3 mb-4">
                            <i class="bi bi-calendar-event fs-2"></i>
                            <div>
                                <strong class="d-block">Data Programada para o Evento:</strong>
                                <span><?= date('d/m/Y', strtotime($noticia['data_evento'])) ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="fs-5 lh-lg text-dark mb-5" style="white-space: pre-line;">
                        <?= converterLinksEmBotoes($noticia['conteudo']) ?>
                    </div>

                    <!-- Botões de Compartilhamento -->
                    <div class="bg-light p-4 rounded-3 border">
                        <h6 class="fw-bold mb-3"><i class="bi bi-share me-2"></i>Compartilhar este comunicado:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="https://api.whatsapp.com/send?text=<?= urlencode($noticia['titulo'] . " - " . $pageUrl) ?>" target="_blank" class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                            <button onclick="copiarLink()" class="btn btn-outline-secondary btn-sm" id="btnCopiar">
                                <i class="bi bi-link-45deg"></i> Copiar Link
                            </button>
                        </div>
                    </div>

                </div>
            </article>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function copiarLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const btn = document.getElementById('btnCopiar');
        btn.innerHTML = '<i class="bi bi-check-lg"></i> Copiado!';
        btn.classList.replace('btn-outline-secondary', 'btn-success');
        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-link-45deg"></i> Copiar Link';
            btn.classList.replace('btn-success', 'btn-outline-secondary');
        }, 3000);
    });
}
    function getBadgeColor($tipo) {
    return match (mb_strtolower(trim($tipo), 'UTF-8')) {
        'aviso institucional', 'aviso' => 'bg-danger',
        'estágio/vaga', 'estagio/vaga', 'vaga' => 'bg-success',
        'evento' => 'bg-warning text-dark',
        'palestra' => 'bg-info text-dark',
        'noticia', 'notícia' => 'bg-primary',
        default => 'bg-secondary',
    };
}
</script>
</body>
</html>