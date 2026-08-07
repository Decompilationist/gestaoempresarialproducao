<?php
// api/api_eventos.php
require_once __DIR__ . '/../includes/config.php';

header('Content-Type: application/json');

$semestre_id = filter_input(INPUT_GET, 'semestre_id', FILTER_VALIDATE_INT);
if (!$semestre_id) {
    echo json_encode([]);
    exit;
}

$eventos_json = [];

// 1. Aulas Lançadas
$stmtAulas = $pdo->prepare("
    SELECT d.*, m.nome as materia_nome, m.professor
    FROM diario_aulas d
    JOIN materias m ON d.materia_id = m.id
    WHERE m.semestre_id = ?
");
$stmtAulas->execute([$semestre_id]);
$aulas = $stmtAulas->fetchAll();

foreach ($aulas as $a) {
    // Se houver horário de início definido, monta no formato ISO (YYYY-MM-DDTHH:MM:SS)
    $start = $a['data_aula'];
    $end = $a['data_aula'];
    
    if (!empty($a['horario_inicio'])) {
        $start .= 'T' . $a['horario_inicio'];
    }
    if (!empty($a['horario_fim'])) {
        $end .= 'T' . $a['horario_fim'];
    }

    $eventos_json[] = [
        'id' => 'aula_' . $a['id'],
        'title' => 'Aula: ' . $a['materia_nome'],
        'start' => $start,
        'end' => $end,
        'color' => '#0d6efd', // Azul Bootstrap
        'extendedProps' => [
            'tipo' => 'aula',
            'materia' => $a['materia_nome'],
            'professor' => $a['professor'],
            'sala' => $a['sala'] ?? '',
            'conteudo' => $a['conteudo'],
            'horario' => ($a['horario_inicio'] ? date('H:i', strtotime($a['horario_inicio'])) : '') . 
                         ($a['horario_fim'] ? ' às ' . date('H:i', strtotime($a['horario_fim'])) : ''),
            'tem_atividade' => (bool)$a['tem_atividade'],
            'imagem_anexo' => $a['imagem_anexo'] ?? ''
        ]
    ];
}

// 2. Provas e Trabalhos (Eventos)
$stmtEventos = $pdo->prepare("
    SELECT e.*, m.nome as materia_nome
    FROM eventos_calendario e
    JOIN materias m ON e.materia_id = m.id
    WHERE m.semestre_id = ?
");
$stmtEventos->execute([$semestre_id]);
$eventos = $stmtEventos->fetchAll();

foreach ($eventos as $e) {
    $eventos_json[] = [
        'id' => 'evento_' . $e['id'],
        'title' => $e['tipo'] . ': ' . $e['materia_nome'],
        'start' => $e['data_evento'],
        'color' => ($e['tipo'] === 'Prova' ? '#dc3545' : '#ffc107'), // Vermelho para Prova, Amarelo para Outros
        'textColor' => ($e['tipo'] === 'Prova' ? '#ffffff' : '#000000'),
        'extendedProps' => [
            'tipo' => 'evento',
            'materia' => $e['materia_nome'],
            'descricao' => $e['descricao'],
            'categoria' => $e['tipo']
        ]
    ];
}

echo json_encode($eventos_json);