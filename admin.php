<?php
// admin.php
require_once __DIR__ . '/includes/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isAdmin()) {
    header("Location: login.php");
    exit;
}

// Recupera e limpa mensagens armazenadas na sessão
$msg = $_SESSION['msg'] ?? '';
$msg_erro = $_SESSION['msg_erro'] ?? '';
unset($_SESSION['msg'], $_SESSION['msg_erro']);

// ==========================================
// 1. PROCESSAMENTO DE AÇÕES (DELETE / GET)
// ==========================================

if (isset($_GET['acao']) && $_GET['acao'] === 'excluir_semestre') {
    $id_semestre = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id_semestre) {
        $checaMaterias = $pdo->prepare("SELECT COUNT(*) FROM materias WHERE semestre_id = ?");
        $checaMaterias->execute([$id_semestre]);
        if ($checaMaterias->fetchColumn() > 0) {
            $_SESSION['msg_erro'] = "Não é possível excluir este semestre pois existem matérias vinculadas a ele.";
        } else {
            $stmt = $pdo->prepare("DELETE FROM semestres WHERE id = ?");
            $stmt->execute([$id_semestre]);
            $_SESSION['msg'] = "Semestre excluído com sucesso!";
        }
    }
    header("Location: admin.php");
    exit;
}

if (isset($_GET['acao']) && $_GET['acao'] === 'excluir_materia') {
    $id_materia = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id_materia) {
        $checaAulas = $pdo->prepare("SELECT COUNT(*) FROM diario_aulas WHERE materia_id = ?");
        $checaAulas->execute([$id_materia]);
        if ($checaAulas->fetchColumn() > 0) {
            $_SESSION['msg_erro'] = "Não é possível excluir esta matéria pois existem aulas lançadas para ela.";
        } else {
            $stmt = $pdo->prepare("DELETE FROM materias WHERE id = ?");
            $stmt->execute([$id_materia]);
            $_SESSION['msg'] = "Matéria excluída com sucesso!";
        }
    }
    header("Location: admin.php");
    exit;
}

if (isset($_GET['acao']) && $_GET['acao'] === 'excluir_aula') {
    $id_aula = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id_aula) {
        $stmtFoto = $pdo->prepare("SELECT imagem_anexo FROM diario_aulas WHERE id = ?");
        $stmtFoto->execute([$id_aula]);
        $aula = $stmtFoto->fetch();
        if ($aula && $aula['imagem_anexo'] && file_exists('uploads/' . $aula['imagem_anexo'])) {
            unlink('uploads/' . $aula['imagem_anexo']);
        }

        $stmt = $pdo->prepare("DELETE FROM diario_aulas WHERE id = ?");
        $stmt->execute([$id_aula]);
        $_SESSION['msg'] = "Aula/Registro excluído com sucesso!";
    }
    header("Location: admin.php");
    exit;
}

if (isset($_GET['acao']) && $_GET['acao'] === 'excluir_evento') {
    $id_evento = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id_evento) {
        $stmt = $pdo->prepare("DELETE FROM eventos_calendario WHERE id = ?");
        $stmt->execute([$id_evento]);
        $_SESSION['msg'] = "Evento/Prova excluído com sucesso!";
    }
    header("Location: admin.php");
    exit;
}

if (isset($_GET['acao']) && $_GET['acao'] === 'excluir_noticia') {
    $id_noticia = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id_noticia) {
        $stmtFoto = $pdo->prepare("SELECT imagem_capa FROM noticias_eventos WHERE id = ?");
        $stmtFoto->execute([$id_noticia]);
        $noticia = $stmtFoto->fetch();
        if ($noticia && $noticia['imagem_capa'] && file_exists('uploads/' . $noticia['imagem_capa'])) {
            unlink('uploads/' . $noticia['imagem_capa']);
        }

        $stmt = $pdo->prepare("DELETE FROM noticias_eventos WHERE id = ?");
        $stmt->execute([$id_noticia]);
        $_SESSION['msg'] = "Notícia/Aviso excluído com sucesso!";
    }
    header("Location: admin.php");
    exit;
}

// ==========================================
// 2. PROCESSAMENTO DE FORMULÁRIOS (POST)
// ==========================================

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    // SALVAR SEMESTRE
    if ($_POST['action'] === 'salvar_semestre') {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nome = trim($_POST['nome'] ?? '');

        if (!empty($nome)) {
            if ($id) {
                $stmt = $pdo->prepare("UPDATE semestres SET nome = ? WHERE id = ?");
                $stmt->execute([$nome, $id]);
                $_SESSION['msg'] = "Semestre atualizado com sucesso!";
            } else {
                $stmt = $pdo->prepare("INSERT INTO semestres (nome) VALUES (?)");
                $stmt->execute([$nome]);
                $_SESSION['msg'] = "Semestre cadastrado com sucesso!";
            }
        } else {
            $_SESSION['msg_erro'] = "Informe o nome do semestre.";
        }
        header("Location: admin.php");
        exit;
    }

    // SALVAR MATÉRIA
    if ($_POST['action'] === 'salvar_materia') {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nome = trim($_POST['nome'] ?? '');
        $professor = trim($_POST['professor'] ?? '');
        $professor_substituto = trim($_POST['professor_substituto'] ?? '');
        $semestre_id = filter_input(INPUT_POST, 'semestre_id', FILTER_VALIDATE_INT);

        if (!empty($nome) && $semestre_id) {
            if ($id) {
                $stmt = $pdo->prepare("UPDATE materias SET nome = ?, professor = ?, professor_substituto = ?, semestre_id = ? WHERE id = ?");
                $stmt->execute([$nome, $professor, $professor_substituto, $semestre_id, $id]);
                $_SESSION['msg'] = "Matéria atualizada com sucesso!";
            } else {
                $stmt = $pdo->prepare("INSERT INTO materias (nome, professor, professor_substituto, semestre_id) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nome, $professor, $professor_substituto, $semestre_id]);
                $_SESSION['msg'] = "Matéria cadastrada com sucesso!";
            }
        } else {
            $_SESSION['msg_erro'] = "Preencha o nome da matéria e selecione o semestre.";
        }
        header("Location: admin.php");
        exit;
    }

    // SALVAR AULA
    if ($_POST['action'] === 'salvar_aula') {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $materia_id = filter_input(INPUT_POST, 'materia_id', FILTER_VALIDATE_INT);
        $data_aula = $_POST['data_aula'] ?? date('Y-m-d');
        $horario = trim($_POST['horario'] ?? '');
        $sala = trim($_POST['sala'] ?? '');
        $conteudo = trim($_POST['conteudo'] ?? '');
        $tem_atividade = isset($_POST['tem_atividade']) ? 1 : 0;

        $nome_imagem = $_POST['imagem_atual'] ?? NULL;
        $erro_upload = false;

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($ext, $extensoes_permitidas)) {
                $novo_nome = uniqid() . '.' . $ext;
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0755, true);
                }
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], 'uploads/' . $novo_nome)) {
                    if ($nome_imagem && file_exists('uploads/' . $nome_imagem)) {
                        unlink('uploads/' . $nome_imagem);
                    }
                    $nome_imagem = $novo_nome;
                }
            } else {
                $_SESSION['msg_erro'] = "Formato de imagem inválido! Envie JPG, PNG ou WEBP.";
                $erro_upload = true;
            }
        }

        if (!$erro_upload && $materia_id && !empty($conteudo)) {
            if ($id) {
                $stmt = $pdo->prepare("UPDATE diario_aulas SET materia_id = ?, data_aula = ?, horario = ?, sala = ?, conteudo = ?, tem_atividade = ?, imagem_anexo = ? WHERE id = ?");
                $stmt->execute([$materia_id, $data_aula, $horario, $sala, $conteudo, $tem_atividade, $nome_imagem, $id]);
                $_SESSION['msg'] = "Registro de aula atualizado com sucesso!";
            } else {
                $stmt = $pdo->prepare("INSERT INTO diario_aulas (materia_id, data_aula, horario, sala, conteudo, tem_atividade, imagem_anexo) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$materia_id, $data_aula, $horario, $sala, $conteudo, $tem_atividade, $nome_imagem]);
                $_SESSION['msg'] = "Aula cadastrada com sucesso!";
            }
        } elseif (!$erro_upload) {
            $_SESSION['msg_erro'] = "Selecione a matéria e informe o resumo do conteúdo.";
        }

        header("Location: admin.php");
        exit;
    }

    // SALVAR EVENTO
    if ($_POST['action'] === 'salvar_evento') {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $materia_id = filter_input(INPUT_POST, 'materia_id', FILTER_VALIDATE_INT);
        $data_evento = $_POST['data_evento'] ?? '';
        $tipo = trim($_POST['tipo'] ?? 'Prova');
        $descricao = trim($_POST['descricao'] ?? '');

        if ($materia_id && !empty($data_evento) && !empty($descricao)) {
            if ($id) {
                $stmt = $pdo->prepare("UPDATE eventos_calendario SET materia_id = ?, data_evento = ?, tipo = ?, descricao = ? WHERE id = ?");
                $stmt->execute([$materia_id, $data_evento, $tipo, $descricao, $id]);
                $_SESSION['msg'] = "Evento atualizado com sucesso!";
            } else {
                $stmt = $pdo->prepare("INSERT INTO eventos_calendario (materia_id, data_evento, tipo, descricao) VALUES (?, ?, ?, ?)");
                $stmt->execute([$materia_id, $data_evento, $tipo, $descricao]);
                $_SESSION['msg'] = "Evento agendado com sucesso!";
            }
        } else {
            $_SESSION['msg_erro'] = "Preencha a matéria, data e descrição do evento.";
        }

        header("Location: admin.php");
        exit;
    }

    // SALVAR NOTÍCIA / AVISO INSTITUCIONAL
    if ($_POST['action'] === 'salvar_noticia') {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $titulo = trim($_POST['titulo'] ?? '');
        $subtitulo = trim($_POST['subtitulo'] ?? '');
        $conteudo = trim($_POST['conteudo'] ?? '');
        $tipo = trim($_POST['tipo'] ?? 'Noticia');
        $data_evento = !empty($_POST['data_evento']) ? $_POST['data_evento'] : NULL;
        $fixado = isset($_POST['fixado']) ? 1 : 0;
        $usuario_id = $_SESSION['usuario_id'] ?? $_SESSION['user_id'] ?? 1;

        $nome_imagem = $_POST['imagem_atual'] ?? NULL;
        $erro_upload = false;

        if (isset($_FILES['imagem_capa']) && $_FILES['imagem_capa']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['imagem_capa']['name'], PATHINFO_EXTENSION));
            $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($ext, $extensoes_permitidas)) {
                $novo_nome = 'noticia_' . uniqid() . '.' . $ext;
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0755, true);
                }
                if (move_uploaded_file($_FILES['imagem_capa']['tmp_name'], 'uploads/' . $novo_nome)) {
                    if ($nome_imagem && file_exists('uploads/' . $nome_imagem)) {
                        unlink('uploads/' . $nome_imagem);
                    }
                    $nome_imagem = $novo_nome;
                }
            } else {
                $_SESSION['msg_erro'] = "Formato de imagem inválido! Envie JPG, PNG ou WEBP.";
                $erro_upload = true;
            }
        }

        if (!$erro_upload && !empty($titulo) && !empty($conteudo)) {
            if ($id) {
                $stmt = $pdo->prepare("UPDATE noticias_eventos SET titulo = ?, subtitulo = ?, conteudo = ?, tipo = ?, data_evento = ?, imagem_capa = ?, fixado = ? WHERE id = ?");
                $stmt->execute([$titulo, $subtitulo, $conteudo, $tipo, $data_evento, $nome_imagem, $fixado, $id]);
                $_SESSION['msg'] = "Notícia/Aviso atualizado com sucesso!";
            } else {
                $stmt = $pdo->prepare("INSERT INTO noticias_eventos (titulo, subtitulo, conteudo, tipo, data_evento, imagem_capa, fixado, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$titulo, $subtitulo, $conteudo, $tipo, $data_evento, $nome_imagem, $fixado, $usuario_id]);
                $_SESSION['msg'] = "Notícia/Aviso cadastrado com sucesso!";
            }
        } elseif (!$erro_upload) {
            $_SESSION['msg_erro'] = "Preencha pelo menos o título e o conteúdo da notícia.";
        }

        header("Location: admin.php");
        exit;
    }
}

// ==========================================
// 3. BUSCA DE DADOS PARA EDIÇÃO E LISTAGEM
// ==========================================

$semestre_edicao = NULL;
if (isset($_GET['editar_semestre'])) {
    $stmt = $pdo->prepare("SELECT * FROM semestres WHERE id = ?");
    $stmt->execute([$_GET['editar_semestre']]);
    $semestre_edicao = $stmt->fetch();
}

$materia_edicao = NULL;
if (isset($_GET['editar_materia'])) {
    $stmt = $pdo->prepare("SELECT * FROM materias WHERE id = ?");
    $stmt->execute([$_GET['editar_materia']]);
    $materia_edicao = $stmt->fetch();
}

$aula_edicao = NULL;
if (isset($_GET['editar_aula'])) {
    $stmt = $pdo->prepare("SELECT * FROM diario_aulas WHERE id = ?");
    $stmt->execute([$_GET['editar_aula']]);
    $aula_edicao = $stmt->fetch();
}

$evento_edicao = NULL;
if (isset($_GET['editar_evento'])) {
    $stmt = $pdo->prepare("SELECT * FROM eventos_calendario WHERE id = ?");
    $stmt->execute([$_GET['editar_evento']]);
    $evento_edicao = $stmt->fetch();
}

$noticia_edicao = NULL;
if (isset($_GET['editar_noticia'])) {
    $stmt = $pdo->prepare("SELECT * FROM noticias_eventos WHERE id = ?");
    $stmt->execute([$_GET['editar_noticia']]);
    $noticia_edicao = $stmt->fetch();
}

$semestres = $pdo->query("SELECT * FROM semestres ORDER BY id ASC")->fetchAll();
$materias = $pdo->query("SELECT m.*, s.nome as semestre FROM materias m JOIN semestres s ON m.semestre_id = s.id ORDER BY s.id DESC, m.nome ASC")->fetchAll();

$aulas_lista = $pdo->query("
    SELECT d.*, m.nome as materia_nome 
    FROM diario_aulas d 
    JOIN materias m ON d.materia_id = m.id 
    ORDER BY d.data_aula DESC, d.id DESC
")->fetchAll();

$eventos_lista = $pdo->query("
    SELECT e.*, m.nome as materia_nome 
    FROM eventos_calendario e 
    JOIN materias m ON e.materia_id = m.id 
    ORDER BY e.data_evento DESC, e.id DESC
")->fetchAll();

$noticias_lista = $pdo->query("
    SELECT n.*, u.nome as autor_nome 
    FROM noticias_eventos n 
    LEFT JOIN usuarios u ON n.usuario_id = u.id 
    ORDER BY n.fixado DESC, n.created_at DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Gestão - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container-fluid px-2 px-md-4 py-3">
    <!-- Cabeçalho Responsivo -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <h2 class="h3 mb-0">Painel Administrativo</h2>
        <div class="d-flex gap-2">
            <a href="noticias.php" class="btn btn-purple text-white btn-sm" style="background-color: #6f42c1;"><i class="bi bi-newspaper"></i> Ver Notícias</a>
            <a href="exportar_excel.php" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Baixar Excel</a>
            <a href="index.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Painel Geral</a>
        </div>
    </div>

    <?php if ($msg): ?>
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <?= htmlspecialchars($msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($msg_erro): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <?= htmlspecialchars($msg_erro) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- FORMULÁRIOS DA PÁGINA -->
    <div class="row g-3">
        <!-- SEMESTRE -->
        <div class="col-12 col-md-6 col-xl-2.4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><?= $semestre_edicao ? 'Editar Semestre' : 'Novo Semestre' ?></span>
                    <?php if ($semestre_edicao): ?>
                        <a href="admin.php" class="btn btn-sm btn-outline-dark">Cancelar</a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="salvar_semestre">
                        <?php if ($semestre_edicao): ?>
                            <input type="hidden" name="id" value="<?= $semestre_edicao['id'] ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Nome do Semestre</label>
                            <input type="text" name="nome" class="form-control" placeholder="Ex: 1º Semestre" value="<?= $semestre_edicao ? htmlspecialchars($semestre_edicao['nome']) : '' ?>" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold"><?= $semestre_edicao ? 'Atualizar' : 'Cadastrar' ?></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- MATÉRIA -->
        <div class="col-12 col-md-6 col-xl-2.4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><?= $materia_edicao ? 'Editar Matéria' : 'Nova Matéria' ?></span>
                    <?php if ($materia_edicao): ?>
                        <a href="admin.php" class="btn btn-sm btn-light">Cancelar</a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="salvar_materia">
                        <?php if ($materia_edicao): ?>
                            <input type="hidden" name="id" value="<?= $materia_edicao['id'] ?>">
                        <?php endif; ?>

                        <div class="mb-2">
                            <label class="form-label">Nome da Matéria</label>
                            <input type="text" name="nome" class="form-control" value="<?= $materia_edicao ? htmlspecialchars($materia_edicao['nome']) : '' ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Professor Titular</label>
                            <input type="text" name="professor" class="form-control" placeholder="Ex: Prof. Carlos" value="<?= $materia_edicao ? htmlspecialchars($materia_edicao['professor']) : '' ?>">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Substituto (Opcional)</label>
                            <input type="text" name="professor_substituto" class="form-control" placeholder="Ex: Prof. Ana" value="<?= $materia_edicao ? htmlspecialchars($materia_edicao['professor_substituto']) : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Semestre</label>
                            <select name="semestre_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($semestres as $s): ?>
                                    <option value="<?= $s['id'] ?>" <?= ($materia_edicao && $materia_edicao['semestre_id'] == $s['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($s['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold"><?= $materia_edicao ? 'Atualizar' : 'Cadastrar' ?></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- AULA -->
        <div class="col-12 col-md-6 col-xl-2.4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><?= $aula_edicao ? 'Editar Aula' : 'Lançar Aula' ?></span>
                    <?php if ($aula_edicao): ?>
                        <a href="admin.php" class="btn btn-sm btn-light">Cancelar</a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="salvar_aula">
                        <?php if ($aula_edicao): ?>
                            <input type="hidden" name="id" value="<?= $aula_edicao['id'] ?>">
                            <input type="hidden" name="imagem_atual" value="<?= htmlspecialchars($aula_edicao['imagem_anexo'] ?? '') ?>">
                        <?php endif; ?>

                        <div class="mb-2">
                            <label class="form-label">Matéria</label>
                            <select name="materia_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($materias as $m): ?>
                                    <option value="<?= $m['id'] ?>" <?= ($aula_edicao && $aula_edicao['materia_id'] == $m['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($m['semestre']) ?> - <?= htmlspecialchars($m['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label">Data</label>
                                <input type="date" name="data_aula" class="form-control" value="<?= $aula_edicao ? $aula_edicao['data_aula'] : date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Horário</label>
                                <select name="horario" class="form-select">
                                    <option value="1ª Aula" <?= ($aula_edicao && $aula_edicao['horario'] === '1ª Aula') ? 'selected' : '' ?>>1ª Aula</option>
                                    <option value="2ª Aula" <?= ($aula_edicao && $aula_edicao['horario'] === '2ª Aula') ? 'selected' : '' ?>>2ª Aula</option>
                                    <option value="1ª e 2ª Aulas" <?= ($aula_edicao && $aula_edicao['horario'] === '1ª e 2ª Aulas') ? 'selected' : '' ?>>1ª e 2ª Aulas</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Sala de Aula</label>
                            <input type="text" name="sala" class="form-control" placeholder="Ex: Bloco B - Sala 102" value="<?= $aula_edicao ? htmlspecialchars($aula_edicao['sala']) : '' ?>">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Resumo</label>
                            <textarea name="conteudo" class="form-control" rows="2" required><?= $aula_edicao ? htmlspecialchars($aula_edicao['conteudo']) : '' ?></textarea>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="tem_atividade" class="form-check-input" id="act" <?= ($aula_edicao && $aula_edicao['tem_atividade']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="act">Atividade/Aviso?</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">Imagem / Anexo</label>
                            <input type="file" name="imagem" class="form-control form-control-sm" accept="image/*">
                            <?php if ($aula_edicao && $aula_edicao['imagem_anexo']): ?>
                                <small class="text-success d-block mt-1"><i class="bi bi-image"></i> Imagem anexada</small>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold"><?= $aula_edicao ? 'Atualizar' : 'Salvar' ?></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- EVENTO MATÉRIA -->
        <div class="col-12 col-md-6 col-xl-2.4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><?= $evento_edicao ? 'Editar Evento' : 'Agendar Evento' ?></span>
                    <?php if ($evento_edicao): ?>
                        <a href="admin.php" class="btn btn-sm btn-light">Cancelar</a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="salvar_evento">
                        <?php if ($evento_edicao): ?>
                            <input type="hidden" name="id" value="<?= $evento_edicao['id'] ?>">
                        <?php endif; ?>

                        <div class="mb-2">
                            <label class="form-label">Matéria</label>
                            <select name="materia_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($materias as $m): ?>
                                    <option value="<?= $m['id'] ?>" <?= ($evento_edicao && $evento_edicao['materia_id'] == $m['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($m['semestre']) ?> - <?= htmlspecialchars($m['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Data</label>
                            <input type="date" name="data_evento" class="form-control" value="<?= $evento_edicao ? $evento_edicao['data_evento'] : '' ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Tipo</label>
                            <select name="tipo" class="form-select" required>
                                <?php $tipos = ['Prova', 'Trabalho', 'Projeto Integrador', 'Outro']; ?>
                                <?php foreach ($tipos as $t): ?>
                                    <option value="<?= $t ?>" <?= ($evento_edicao && $evento_edicao['tipo'] == $t) ? 'selected' : '' ?>><?= $t ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <input type="text" name="descricao" class="form-control" value="<?= $evento_edicao ? htmlspecialchars($evento_edicao['descricao']) : '' ?>" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 fw-bold"><?= $evento_edicao ? 'Atualizar' : 'Agendar' ?></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- NOTÍCIA / AVISO INSTITUCIONAL -->
        <div class="col-12 col-md-6 col-xl-2.4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #6f42c1;">
                    <span class="fw-bold"><?= $noticia_edicao ? 'Editar Notícia' : 'Nova Notícia/Aviso' ?></span>
                    <?php if ($noticia_edicao): ?>
                        <a href="admin.php" class="btn btn-sm btn-light">Cancelar</a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="salvar_noticia">
                        <?php if ($noticia_edicao): ?>
                            <input type="hidden" name="id" value="<?= $noticia_edicao['id'] ?>">
                            <input type="hidden" name="imagem_atual" value="<?= htmlspecialchars($noticia_edicao['imagem_capa'] ?? '') ?>">
                        <?php endif; ?>

                        <div class="mb-2">
                            <label class="form-label">Título</label>
                            <input type="text" name="titulo" class="form-control" placeholder="Ex: Feira de Profissões 2026" value="<?= $noticia_edicao ? htmlspecialchars($noticia_edicao['titulo']) : '' ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Subtítulo (Opcional)</label>
                            <input type="text" name="subtitulo" class="form-control" placeholder="Resumo em uma linha" value="<?= $noticia_edicao ? htmlspecialchars($noticia_edicao['subtitulo']) : '' ?>">
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label">Tipo</label>
                                <select name="tipo" class="form-select" required>
                                    <?php $tipos = ['Noticia', 'Evento', 'Aviso Institucional', 'Palestra', 'Estágio/Vaga']; ?>
                                    <?php foreach ($tipos as $t): ?>
                                        <option value="<?= $t ?>" <?= ($noticia_edicao && $noticia_edicao['tipo'] == $t) ? 'selected' : '' ?>><?= $t ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Data Evento</label>
                                <input type="date" name="data_evento" class="form-control" value="<?= $noticia_edicao ? $noticia_edicao['data_evento'] : '' ?>">
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Conteúdo Completo</label>
                            <textarea name="conteudo" class="form-control" rows="2" required><?= $noticia_edicao ? htmlspecialchars($noticia_edicao['conteudo']) : '' ?></textarea>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="fixado" class="form-check-input" id="fix" <?= ($noticia_edicao && $noticia_edicao['fixado']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="fix">Fixar no topo?</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">Capa / Imagem</label>
                            <input type="file" name="imagem_capa" class="form-control form-control-sm" accept="image/*">
                            <?php if ($noticia_edicao && $noticia_edicao['imagem_capa']): ?>
                                <small class="text-success d-block mt-1"><i class="bi bi-image"></i> Capa cadastrada</small>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn text-white w-100 fw-bold" style="background-color: #6f42c1;"><?= $noticia_edicao ? 'Atualizar' : 'Publicar' ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- LISTAGENS COM TABELAS RESPONSIVAS E PESQUISA -->
    <div class="row g-3 mt-1">
        <!-- SEMESTRES -->
        <div class="col-12 col-md-6 col-xl-2">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold d-flex flex-column gap-2">
                    <span>Semestres</span>
                    <input type="text" class="form-control form-control-sm tabela-busca" placeholder="🔍 Buscar..." data-target="tabela-semestres">
                </div>
                <div class="table-responsive" style="max-height: 350px;">
                    <table class="table table-hover align-middle mb-0" id="tabela-semestres">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($semestres as $sem): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($sem['nome']) ?></strong></td>
                                <td class="text-end">
                                    <a href="admin.php?editar_semestre=<?= $sem['id'] ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                    <a href="admin.php?acao=excluir_semestre&id=<?= $sem['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir este semestre?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MATÉRIAS -->
        <div class="col-12 col-md-6 col-xl-2.5">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold d-flex flex-column gap-2">
                    <span>Matérias & Professores</span>
                    <input type="text" class="form-control form-control-sm tabela-busca" placeholder="🔍 Buscar matéria/prof..." data-target="tabela-materias">
                </div>
                <div class="table-responsive" style="max-height: 350px;">
                    <table class="table table-hover align-middle mb-0" id="tabela-materias">
                        <thead>
                            <tr>
                                <th>Matéria / Docente</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($materias as $mat): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($mat['nome']) ?></strong>
                                    <small class="text-muted d-block"><?= htmlspecialchars($mat['semestre']) ?></small>
                                    <?php if ($mat['professor']): ?>
                                        <small class="text-primary d-block"><i class="bi bi-person"></i> <?= htmlspecialchars($mat['professor']) ?></small>
                                    <?php endif; ?>
                                    <?php if ($mat['professor_substituto']): ?>
                                        <small class="text-secondary d-block"><i class="bi bi-person-badge"></i> Sub: <?= htmlspecialchars($mat['professor_substituto']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="admin.php?editar_materia=<?= $mat['id'] ?>" class="btn btn-sm btn-outline-success"><i class="bi bi-pencil"></i></a>
                                    <a href="admin.php?acao=excluir_materia&id=<?= $mat['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir esta matéria?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- AULAS LANÇADAS -->
        <div class="col-12 col-md-6 col-xl-2.5">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold d-flex flex-column gap-2">
                    <span>Aulas Lançadas</span>
                    <input type="text" class="form-control form-control-sm tabela-busca" placeholder="🔍 Buscar aula..." data-target="tabela-aulas">
                </div>
                <div class="table-responsive" style="max-height: 350px;">
                    <table class="table table-hover align-middle mb-0" id="tabela-aulas">
                        <thead>
                            <tr>
                                <th>Data / Matéria / Sala</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aulas_lista as $a): ?>
                            <tr>
                                <td>
                                    <small class="text-muted d-block">
                                        <?= date('d/m/Y', strtotime($a['data_aula'])) ?>
                                        <?= !empty($a['horario']) ? ' • ' . htmlspecialchars($a['horario']) : '' ?>
                                    </small>
                                    <strong><?= htmlspecialchars($a['materia_nome']) ?></strong>
                                    <?php if ($a['sala']): ?>
                                        <small class="text-primary d-block fw-semibold"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($a['sala']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="admin.php?editar_aula=<?= $a['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <a href="admin.php?acao=excluir_aula&id=<?= $a['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir este registro?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- EVENTOS MATÉRIA -->
        <div class="col-12 col-md-6 col-xl-2.5">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold d-flex flex-column gap-2">
                    <span>Provas / Eventos</span>
                    <input type="text" class="form-control form-control-sm tabela-busca" placeholder="🔍 Buscar evento..." data-target="tabela-eventos">
                </div>
                <div class="table-responsive" style="max-height: 350px;">
                    <table class="table table-hover align-middle mb-0" id="tabela-eventos">
                        <thead>
                            <tr>
                                <th>Data / Evento</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($eventos_lista as $ev): ?>
                            <tr>
                                <td>
                                    <small class="text-muted d-block"><?= date('d/m/Y', strtotime($ev['data_evento'])) ?></small>
                                    <strong><?= htmlspecialchars($ev['materia_nome']) ?></strong>
                                    <span class="d-block text-secondary small"><?= htmlspecialchars($ev['descricao']) ?></span>
                                </td>
                                <td class="text-end">
                                    <a href="admin.php?editar_evento=<?= $ev['id'] ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-pencil"></i></a>
                                    <a href="admin.php?acao=excluir_evento&id=<?= $ev['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir este evento?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- NOTÍCIAS & AVISOS -->
        <div class="col-12 col-md-6 col-xl-2.5">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Notícias & Avisos</span>
                        <span class="badge bg-purple" style="background-color: #6f42c1;"><?= count($noticias_lista) ?></span>
                    </div>
                    <input type="text" class="form-control form-control-sm tabela-busca" placeholder="🔍 Buscar notícia..." data-target="tabela-noticias">
                </div>
                <div class="table-responsive" style="max-height: 350px;">
                    <table class="table table-hover align-middle mb-0" id="tabela-noticias">
                        <thead>
                            <tr>
                                <th>Notícia / Categoria</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($noticias_lista as $not): ?>
                            <tr>
                                <td>
                                    <?php if ($not['fixado']): ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-pin-angle-fill"></i> Fixado</span>
                                    <?php endif; ?>
                                    <span class="badge bg-secondary"><?= htmlspecialchars($not['tipo']) ?></span>
                                    <strong class="d-block mt-1"><?= htmlspecialchars($not['titulo']) ?></strong>
                                    <small class="text-muted d-block">
                                        Por: <?= htmlspecialchars($not['autor_nome'] ?? 'Admin') ?>
                                    </small>
                                </td>
                                <td class="text-end">
                                    <a href="admin.php?editar_noticia=<?= $not['id'] ?>" class="btn btn-sm btn-outline-purple" style="color: #6f42c1; border-color: #6f42c1;"><i class="bi bi-pencil"></i></a>
                                    <a href="admin.php?acao=excluir_noticia&id=<?= $not['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir esta notícia?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SCRIPT DE BUSCA RÁPIDA NAS TABELAS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tabela-busca').forEach(function (input) {
        input.addEventListener('input', function () {
            const termoBusca = this.value.toLowerCase().trim();
            const targetId = this.getAttribute('data-target');
            const tabela = document.getElementById(targetId);

            if (!tabela) return;

            const linhas = tabela.querySelectorAll('tbody tr');

            linhas.forEach(function (linha) {
                const textoLinha = linha.textContent.toLowerCase();
                if (textoLinha.includes(termoBusca)) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        });
    });
});
</script>
</body>
</html>