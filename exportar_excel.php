<?php
// exportar_excel.php
require_once __DIR__ . '/includes/config.php';

if (!isAdmin()) {
    header("Location: login.php");
    exit;
}

// Configuração dos cabeçalhos para forçar o download como Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Relatorio_Aulas_" . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Consulta os dados
$stmt = $pdo->query("
    SELECT d.data_aula, d.horario, m.nome as materia_nome, d.sala, d.conteudo, d.tem_atividade
    FROM diario_aulas d 
    JOIN materias m ON d.materia_id = m.id 
    ORDER BY d.data_aula DESC
");
$aulas = $stmt->fetchAll();

// Gera a tabela HTML que o Excel interpreta nativamente
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1">
    <thead>
        <tr style="background-color: #0d6efd; color: #ffffff;">
            <th>Data</th>
            <th>Horário</th>
            <th>Matéria</th>
            <th>Sala</th>
            <th>Conteúdo</th>
            <th>Atividade/Aviso</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($aulas as $a): ?>
        <tr>
            <td><?= date('d/m/Y', strtotime($a['data_aula'])) ?></td>
            <td><?= htmlspecialchars($a['horario'] ?? '-') ?></td>
            <td><?= htmlspecialchars($a['materia_nome']) ?></td>
            <td><?= htmlspecialchars($a['sala'] ?? '-') ?></td>
            <td><?= htmlspecialchars($a['conteudo']) ?></td>
            <td><?= $a['tem_atividade'] ? 'Sim' : 'Não' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>