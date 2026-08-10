<?php
// noticias.php
require_once __DIR__ . '/includes/config.php';

// Consulta notícias ordenadas pela Data do Evento (ou Data de Criação caso não haja evento)
try {
    $stmt = $pdo->prepare("
        SELECT n.*, u.nome AS autor 
        FROM noticias_eventos n 
        LEFT JOIN usuarios u ON n.usuario_id = u.id 
        ORDER BY 
            n.fixado DESC, 
            COALESCE(n.data_evento, n.created_at) DESC, 
            n.created_at DESC 
        LIMIT 10
    ");
    $stmt->execute();
    $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na consulta do banco de dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias e Avisos - Fatec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .card-img-hover {
            max-height: 250px; 
            object-fit: cover; 
            cursor: pointer;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }
        .card-img-hover:hover {
            opacity: 0.9;
            transform: scale(1.01);
        }
    </style>
</head>
<body class="bg-light">

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📢 Notícias e Avisos Fatec</h2>
        <a href="index.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Voltar</a>
    </div>

    <div class="row">
        <?php if (empty($noticias)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">Nenhuma notícia ou aviso cadastrado no momento.</div>
            </div>
        <?php else: ?>
            <?php foreach ($noticias as $item): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 <?= $item['fixado'] ? 'border-warning shadow-sm' : '' ?>">
                        <?php if (!empty($item['imagem_capa']) && file_exists('uploads/' . $item['imagem_capa'])): ?>
                            <div class="position-relative">
                                <img src="uploads/<?= htmlspecialchars($item['imagem_capa']) ?>" 
                                     class="card-img-top card-img-hover img-expandivel" 
                                     alt="Capa"
                                     data-titulo="<?= htmlspecialchars($item['titulo']) ?>"
                                     data-img="uploads/<?= htmlspecialchars($item['imagem_capa']) ?>">
                                <span class="badge bg-dark position-absolute bottom-0 end-0 m-2 opacity-75">
                                    <i class="bi bi-zoom-in"></i> Clique para ampliar
                                </span>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary"><?= htmlspecialchars($item['tipo']) ?></span>
                                <small class="text-muted">Publicado em: <?= date('d/m/Y', strtotime($item['created_at'])) ?></small>
                            </div>
                            
                            <h5 class="card-title"><?= htmlspecialchars($item['titulo']) ?></h5>
                            
                            <?php if (!empty($item['subtitulo'])): ?>
                                <p class="card-text text-muted fw-semibold"><?= htmlspecialchars($item['subtitulo']) ?></p>
                            <?php endif; ?>
                            
                            <p class="card-text"><?= nl2br(htmlspecialchars($item['conteudo'])) ?></p>
                            
                            <?php if (!empty($item['data_evento'])): ?>
                                <div class="alert alert-info py-1 px-2 mt-2 mb-0">
                                    📅 <strong>Data do Evento:</strong> <?= date('d/m/Y', strtotime($item['data_evento'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-footer bg-transparent">
                            <small class="text-muted">Publicado por: <?= htmlspecialchars($item['autor'] ?? 'Administração') ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL PARA AMPLIAR A IMAGEM -->
<div class="modal fade" id="modalImagem" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-secondary">
        <h5 class="modal-title fs-6" id="modalImagemTitulo"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-2">
        <img src="" id="modalImagemSrc" class="img-fluid rounded" alt="Imagem ampliada">
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modalImagem = new bootstrap.Modal(document.getElementById('modalImagem'));
    var modalImgSrc = document.getElementById('modalImagemSrc');
    var modalImgTitulo = document.getElementById('modalImagemTitulo');

    document.querySelectorAll('.img-expandivel').forEach(function(img) {
        img.addEventListener('click', function() {
            var src = this.getAttribute('data-img');
            var titulo = this.getAttribute('data-titulo');
            
            modalImgSrc.setAttribute('src', src);
            modalImgTitulo.textContent = titulo;
            
            modalImagem.show();
        });
    });
});
</script>
</body>
</html>
