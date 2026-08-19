<?php
require_once __DIR__ . '/includes/config.php';

// Mapeamento de cores por tipo exato do banco de dados
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

$categoria_filtro = $_GET['cat'] ?? 'todas';

try {
    $sql = "
        SELECT n.*, u.nome AS autor 
        FROM noticias_eventos n 
        LEFT JOIN usuarios u ON n.usuario_id = u.id 
    ";
    
    if ($categoria_filtro !== 'todas') {
        $sql .= " WHERE LOWER(n.tipo) LIKE :cat";
    }

    $sql .= " ORDER BY n.fixado DESC, COALESCE(n.data_evento, n.created_at) DESC LIMIT 12";

    $stmt = $pdo->prepare($sql);
    if ($categoria_filtro !== 'todas') {
        $stmt->bindValue(':cat', '%' . mb_strtolower($categoria_filtro, 'UTF-8') . '%');
    }
    $stmt->execute();
    $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na consulta do banco de dados.");
}

$destaque = null;
if (!empty($noticias) && $categoria_filtro === 'todas') {
    $destaque = array_shift($noticias);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Notícias - Fatec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .card-noticia {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: none;
        }
        .card-noticia:hover {
            transform: translateY(-4px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.12)!important;
        }
        .img-wrapper {
            overflow: hidden;
        }
        .img-wrapper img {
            transition: transform 0.3s ease;
            object-fit: cover;
            cursor: pointer;
        }
        .card-noticia:hover .img-wrapper img {
            transform: scale(1.04);
        }
        .text-truncate-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .hero-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            border-radius: 12px;
        }
    </style>
</head>
<body class="bg-body-tertiary">

<div class="container my-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h2 class="fw-bold mb-0 text-primary"><i class="bi bi-newspaper me-2"></i>Portal de Notícias & Informativos</h2>
            <p class="text-muted small mb-0">Comunicados acadêmicos, palestras, vagas de estágio e eventos</p>
        </div>
        <a href="index.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Voltar ao Início</a>
    </div>

    <!-- Filtros por Categorias do Banco de Dados -->
    <div class="d-flex gap-2 mb-4 overflow-x-auto pb-2">
        <a href="noticias.php?cat=todas" class="btn btn-sm <?= $categoria_filtro === 'todas' ? 'btn-dark' : 'btn-outline-dark' ?>">Todas</a>
        <a href="noticias.php?cat=noticia" class="btn btn-sm <?= $categoria_filtro === 'noticia' ? 'btn-primary' : 'btn-outline-primary' ?>">Notícias</a>
        <a href="noticias.php?cat=evento" class="btn btn-sm <?= $categoria_filtro === 'evento' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' ?>">Eventos</a>
        <a href="noticias.php?cat=aviso" class="btn btn-sm <?= $categoria_filtro === 'aviso' ? 'btn-danger' : 'btn-outline-danger' ?>">Avisos Institucionais</a>
        <a href="noticias.php?cat=palestra" class="btn btn-sm <?= $categoria_filtro === 'palestra' ? 'btn-info text-dark' : 'btn-outline-info text-dark' ?>">Palestras</a>
        <a href="noticias.php?cat=estágio/vaga" class="btn btn-sm <?= ($categoria_filtro === 'estágio/vaga' || $categoria_filtro === 'vaga') ? 'btn-success' : 'btn-outline-success' ?>">Estágios / Vagas</a>
    </div>

    <!-- NOTÍCIA DE DESTAQUE (HERO) -->
    <?php if ($destaque): ?>
        <div class="card hero-card shadow-lg border-0 mb-5 overflow-hidden">
            <div class="row g-0">
                <?php if (!empty($destaque['imagem_capa']) && file_exists('uploads/' . $destaque['imagem_capa'])): ?>
                    <div class="col-md-6 img-wrapper ratio ratio-16x9">
                        <img src="uploads/<?= htmlspecialchars($destaque['imagem_capa']) ?>" 
                             class="img-expandivel" 
                             alt="Capa Destaque"
                             data-titulo="<?= htmlspecialchars($destaque['titulo']) ?>"
                             data-img="uploads/<?= htmlspecialchars($destaque['imagem_capa']) ?>">
                    </div>
                <?php endif; ?>
                <div class="col-md-<?= (!empty($destaque['imagem_capa']) && file_exists('uploads/' . $destaque['imagem_capa'])) ? '6' : '12' ?> p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <?php if ($destaque['fixado']): ?>
                                <span class="badge bg-warning text-dark"><i class="bi bi-pin-angle-fill"></i> Destaque Fixado</span>
                            <?php endif; ?>
                            <span class="badge <?= getBadgeColor($destaque['tipo']) ?>"><?= htmlspecialchars($destaque['tipo']) ?></span>
                            <small class="text-white-50"><i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($destaque['created_at'])) ?></small>
                        </div>
                        <h3 class="fw-bold mb-2 text-white"><?= htmlspecialchars($destaque['titulo']) ?></h3>
                        <?php if (!empty($destaque['subtitulo'])): ?>
                            <h6 class="text-warning fw-semibold mb-3"><?= htmlspecialchars($destaque['subtitulo']) ?></h6>
                        <?php endif; ?>
                        <div class="text-light opacity-75 mb-3 text-truncate-3">
                            <?= strip_tags($destaque['conteudo']) ?>
                        </div>
                    </div>
                    <div>
                        <a href="noticia_detalhe.php?id=<?= $destaque['id'] ?>" class="btn btn-primary btn-sm mb-3"><i class="bi bi-book me-1"></i> Ler Notícia Completa</a>
                        <div class="pt-3 border-top border-secondary text-white-50 small d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-person-circle"></i> <?= htmlspecialchars($destaque['autor'] ?? 'Administração') ?></span>
                            <?php if (!empty($destaque['data_evento'])): ?>
                                <span class="badge bg-info text-dark"><i class="bi bi-calendar-event"></i> Data: <?= date('d/m/Y', strtotime($destaque['data_evento'])) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- GRID DE NOTÍCIAS -->
    <div class="row g-4">
        <?php if (empty($noticias) && !$destaque): ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-5 shadow-sm border-0">
                    <i class="bi bi-info-circle fs-2 d-block mb-2"></i>
                    Nenhum registro encontrado para a categoria selecionada.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($noticias as $item): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 card-noticia shadow-sm bg-white rounded-3">
                        
                        <?php if (!empty($item['imagem_capa']) && file_exists('uploads/' . $item['imagem_capa'])): ?>
                            <div class="img-wrapper ratio ratio-16x9 rounded-top">
                                <img src="uploads/<?= htmlspecialchars($item['imagem_capa']) ?>" 
                                     class="img-expandivel" 
                                     alt="Capa"
                                     data-titulo="<?= htmlspecialchars($item['titulo']) ?>"
                                     data-img="uploads/<?= htmlspecialchars($item['imagem_capa']) ?>">
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex gap-1 align-items-center">
                                    <span class="badge <?= getBadgeColor($item['tipo']) ?>"><?= htmlspecialchars($item['tipo']) ?></span>
                                    <?php if ($item['fixado']): ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-pin-angle-fill"></i></span>
                                    <?php endif; ?>
                                </div>
                                <small class="text-muted"><i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($item['created_at'])) ?></small>
                            </div>
                            
                            <h5 class="card-title fw-bold text-dark mb-1"><?= htmlspecialchars($item['titulo']) ?></h5>
                            
                            <?php if (!empty($item['subtitulo'])): ?>
                                <h6 class="card-subtitle mb-2 text-secondary fw-semibold small"><?= htmlspecialchars($item['subtitulo']) ?></h6>
                            <?php endif; ?>
                            
                            <p class="card-text text-secondary mt-2 flex-grow-1 text-truncate-3">
                                <?= strip_tags($item['conteudo']) ?>
                            </p>

                            <a href="noticia_detalhe.php?id=<?= $item['id'] ?>" class="btn btn-outline-primary btn-sm w-100 mt-2 mb-2">
                                <i class="bi bi-eye"></i> Ler Notícia Completa
                            </a>
                            
                            <?php if (!empty($item['data_evento'])): ?>
                                <div class="alert alert-light border-start border-info border-4 py-2 px-3 mt-2 mb-0">
                                    <small class="text-muted d-block">Data Relacionada / Evento</small>
                                    <strong class="text-dark"><i class="bi bi-calendar-event"></i> <?= date('d/m/Y', strtotime($item['data_evento'])) ?></strong>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-3">
                            <hr class="mt-0 mb-2">
                            <small class="text-muted d-flex align-items-center gap-1">
                                <i class="bi bi-person-circle"></i> <?= htmlspecialchars($item['autor'] ?? 'Administração') ?>
                            </small>
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
      <div class="modal-header border-secondary py-2">
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
            modalImgSrc.setAttribute('src', this.getAttribute('data-img'));
            modalImgTitulo.textContent = this.getAttribute('data-titulo');
            modalImagem.show();
        });
    });
});
</script>
</body>
</html>