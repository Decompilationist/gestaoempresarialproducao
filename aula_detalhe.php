<?php
require_once 'includes/header.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php");
    exit;
}

// Converter URLs em botões clicáveis
function converterLinksEmBotoes($texto) {
    $pattern = '/https?:\/\/[^\s<]+/';
    return preg_replace_callback($pattern, function($matches) {
        $url = htmlspecialchars($matches[0]);
        return '<br><a href="' . $url . '" target="_blank" rel="noopener noreferrer" class="btn btn-primary mt-2"><i class="bi bi-box-arrow-up-right"></i> Abrir Link / Documento Relacionado</a>';
    }, nl2br(htmlspecialchars($texto)));
}

try {
    $sql = "
        SELECT d.*, m.nome as materia_nome, m.professor, s.nome as semestre_nome
        FROM diario_aulas d
        JOIN materias m ON d.materia_id = m.id
        LEFT JOIN semestres s ON m.semestre_id = s.id
        WHERE d.id = :id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $aula = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$aula) {
        header("Location: index.php");
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao buscar a aula.");
}

$pageUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <a href="index.php" class="btn btn-outline-secondary btn-sm mb-4">
                <i class="bi bi-arrow-left me-1"></i> Voltar para o Diário
            </a>

            <article class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                
                <?php if (!empty($aula['imagem_anexo']) && file_exists('uploads/' . $aula['imagem_anexo'])): ?>
                    <div class="ratio ratio-21x9 bg-dark">
                        <img src="uploads/<?= htmlspecialchars($aula['imagem_anexo']) ?>" class="object-fit-cover" alt="Anexo da Lousa">
                    </div>
                <?php endif; ?>

                <div class="card-body p-4 p-md-5">
                    
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-primary px-3 py-2 fs-6"><?= htmlspecialchars($aula['materia_nome']) ?></span>
                        <?php if ($aula['tem_atividade']): ?>
                            <span class="badge bg-warning text-dark px-3 py-2 fs-6"><i class="bi bi-exclamation-circle"></i> Com Atividade</span>
                        <?php endif; ?>
                    </div>

                    <h1 class="fw-bold text-dark mb-2">Aula do dia <?= date('d/m/Y', strtotime($aula['data_aula'])) ?></h1>

                    <div class="d-flex flex-wrap justify-content-between align-items-center border-top border-bottom py-3 mb-4 text-muted small">
                        <div>
                            <i class="bi bi-person-circle me-1"></i> Prof. <strong><?= htmlspecialchars($aula['professor']) ?></strong>
                        </div>
                        <div>
                            <?php if(!empty($aula['horario'])): ?>
                                <span class="me-3"><i class="bi bi-clock me-1"></i> <?= htmlspecialchars($aula['horario']) ?></span>
                            <?php endif; ?>
                            <?php if(!empty($aula['sala'])): ?>
                                <span><i class="bi bi-geo-alt me-1"></i> Sala: <strong><?= htmlspecialchars($aula['sala']) ?></strong></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="fs-5 lh-lg text-dark mb-5" style="white-space: pre-line;">
                        <?= converterLinksEmBotoes($aula['conteudo']) ?>
                    </div>

                    <?php if (!empty($aula['imagem_anexo']) && file_exists('uploads/' . $aula['imagem_anexo'])): ?>
                        <div class="alert alert-light border p-3 mb-4">
                            <h6 class="fw-bold"><i class="bi bi-image me-1"></i> Anexo / Foto da Lousa</h6>
                            <a href="uploads/<?= htmlspecialchars($aula['imagem_anexo']) ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="bi bi-box-arrow-up-right"></i> Ver Imagem em Tamanho Real
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Compartilhamento -->
                    <div class="bg-light p-4 rounded-3 border">
                        <h6 class="fw-bold mb-3"><i class="bi bi-share me-2"></i>Compartilhar este conteúdo de aula:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="https://api.whatsapp.com/send?text=<?= urlencode("Conteúdo da Aula - " . $aula['materia_nome'] . ": " . $pageUrl) ?>" target="_blank" class="btn btn-success btn-sm">
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
</script>

<?php require_once 'includes/footer.php'; ?>