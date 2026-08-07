<?php
require_once 'includes/header.php';

// Carregar semestres para o filtro
$semestres = $pdo->query("SELECT * FROM semestres ORDER BY id ASC")->fetchAll();
$semestre_id = $_GET['semestre_id'] ?? ($semestres[0]['id'] ?? 1);

// Busca dados do semestre selecionado para pegar a data de início
$semestre_ativo = null;
foreach ($semestres as $s) {
    if ($s['id'] == $semestre_id) {
        $semestre_ativo = $s;
        break;
    }
}
$data_inicial_calendario = (!empty($semestre_ativo['data_inicio'])) ? $semestre_ativo['data_inicio'] : date('Y-m-d');

// Carregar matérias do semestre ativo
$stmtMat = $pdo->prepare("SELECT * FROM materias WHERE semestre_id = ? ORDER BY nome ASC");
$stmtMat->execute([$semestre_id]);
$materias = $stmtMat->fetchAll();

// Filtros adicionais do diário
$materia_filtro = $_GET['materia_id'] ?? '';
$apenas_pendentes = isset($_GET['apenas_pendentes']) && $_GET['apenas_pendentes'] == '1';

// Query Dinâmica do Diário de Bordo
$sqlAulas = "
    SELECT d.*, m.nome as materia_nome, m.professor 
    FROM diario_aulas d 
    JOIN materias m ON d.materia_id = m.id 
    WHERE m.semestre_id = :semestre_id
";

if ($materia_filtro) {
    $sqlAulas .= " AND d.materia_id = :materia_id";
}
if ($apenas_pendentes) {
    $sqlAulas .= " AND d.tem_atividade = 1";
}

$sqlAulas .= " ORDER BY d.data_aula DESC, d.horario ASC LIMIT 30";

$stmtAulas = $pdo->prepare($sqlAulas);
$stmtAulas->bindValue(':semestre_id', $semestre_id, PDO::PARAM_INT);
if ($materia_filtro) {
    $stmtAulas->bindValue(':materia_id', $materia_filtro, PDO::PARAM_INT);
}
$stmtAulas->execute();
$aulas = $stmtAulas->fetchAll();

// QUERY DO WIDGET: Provas e Trabalhos nos próximos dias
$stmtProximos = $pdo->prepare("
    SELECT e.*, m.nome as materia_nome, DATEDIFF(e.data_evento, CURDATE()) as dias_restantes
    FROM eventos_calendario e
    JOIN materias m ON e.materia_id = m.id
    WHERE m.semestre_id = ? AND e.data_evento >= CURDATE()
    ORDER BY e.data_evento ASC
    LIMIT 3
");
$stmtProximos->execute([$semestre_id]);
$proximos_eventos = $stmtProximos->fetchAll();
?>

<!-- Biblioteca SheetJS para exportação do Excel -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<!-- Estilos para deixar o calendário super responsivo no celular -->
<style>
@media (max-width: 768px) {
    .fc .fc-toolbar-title {
        font-size: 1.1rem !important;
    }
    .fc .fc-button {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.8rem !important;
    }
    .fc .fc-toolbar {
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: center !important;
    }
    .fc .fc-toolbar-chunk {
        display: flex;
        justify-content: center;
        align-items: center;
    }
}
</style>

<!-- WIDGET DE ALERTA RÁPIDO: PROVAS PRÓXIMAS -->
<?php if(!empty($proximos_eventos)): ?>
<div class="row mb-4">
    <div class="col-12">
        <h6 class="text-uppercase text-muted fw-bold mb-2">
            <i class="bi bi-bell-fill text-warning"></i> Atenção - Próximas Avaliações
        </h6>
        <div class="row g-2">
            <?php foreach($proximos_eventos as $ev): ?>
                <?php 
                    $badge_class = $ev['dias_restantes'] <= 3 ? 'bg-danger' : 'bg-warning text-dark';
                    $texto_dias = $ev['dias_restantes'] == 0 ? 'Hoje!' : ($ev['dias_restantes'] == 1 ? 'Amanhã!' : "Faltam {$ev['dias_restantes']} dias");
                ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
                        <div class="card-body py-2 px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge <?= $badge_class ?>"><?= $texto_dias ?></span>
                                <small class="text-muted"><?= date('d/m/Y', strtotime($ev['data_evento'])) ?></small>
                            </div>
                            <strong class="d-block mt-1"><?= htmlspecialchars($ev['materia_nome']) ?></strong>
                            <small class="text-secondary"><?= htmlspecialchars($ev['tipo']) ?>: <?= htmlspecialchars($ev['descricao']) ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- BARRA DE FILTROS AVANÇADOS -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <!-- Filtro Semestre -->
            <div class="col-md-3">
                <label class="form-label fw-bold">Semestre Letivo</label>
                <select name="semestre_id" class="form-select" onchange="this.form.submit()">
                    <?php foreach($semestres as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= $s['id'] == $semestre_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Filtro Matéria/Professor -->
            <div class="col-md-4">
                <label class="form-label fw-bold">Matéria / Professor</label>
                <select name="materia_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Todas as matérias</option>
                    <?php foreach($materias as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= $m['id'] == $materia_filtro ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['nome']) ?> (Prof. <?= htmlspecialchars($m['professor']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Checkbox Pendências -->
            <div class="col-md-3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="apenas_pendentes" value="1" id="pend" <?= $apenas_pendentes ? 'checked' : '' ?> onchange="this.form.submit()">
                    <label class="form-check-label fw-bold" for="pend">
                        Apenas com Atividades Pendentes
                    </label>
                </div>
            </div>

            <div class="col-md-2">
                <a href="index.php?semestre_id=<?= $semestre_id ?>" class="btn btn-outline-secondary w-100">Limpar Filtros</a>
            </div>
        </form>
    </div>
</div>

<!-- ABAS: CALENDÁRIO INTERATIVO PRIMEIRO -->
<ul class="nav nav-tabs mb-3" id="mainTabs" role="tablist">
  <li class="nav-item">
    <button class="nav-link active fw-bold" id="calendario-tab" data-bs-toggle="tab" data-bs-target="#calendario-view" type="button"><i class="bi bi-calendar-week"></i> Calendário do Semestre</button>
  </li>
  <li class="nav-item">
    <button class="nav-link fw-bold" id="diario-tab" data-bs-toggle="tab" data-bs-target="#diario" type="button"><i class="bi bi-journal-text"></i> Diário de Aulas</button>
  </li>
</ul>

<div class="tab-content" id="mainTabsContent">
  
  <!-- ABA 1: CALENDÁRIO INTERATIVO (ABRE POR PADRÃO) -->
  <div class="tab-pane fade show active" id="calendario-view" role="tabpanel">
      <div class="card shadow-sm p-3">
          <div id="calendar"></div>
      </div>
  </div>

  <!-- ABA 2: DIÁRIO DE AULAS -->
  <div class="tab-pane fade" id="diario" role="tabpanel">
      <div class="row">
          <?php if(empty($aulas)): ?>
              <div class="col-12"><div class="alert alert-info">Nenhum registro encontrado para os filtros selecionados.</div></div>
          <?php else: ?>
              <?php foreach($aulas as $aula): ?>
                  <div class="col-md-6 mb-3">
                      <div class="card h-100 shadow-sm">
                          <div class="card-header bg-white d-flex justify-content-between align-items-center">
                              <span class="fw-bold text-primary"><?= htmlspecialchars($aula['materia_nome']) ?></span>
                              <div>
                                  <?php if(!empty($aula['horario'])): ?>
                                      <span class="badge bg-secondary me-1">
                                          <i class="bi bi-clock"></i> 
                                          <?= htmlspecialchars($aula['horario']) ?>
                                      </span>
                                  <?php endif; ?>
                                  <span class="badge bg-light text-dark border"><?= date('d/m/Y', strtotime($aula['data_aula'])) ?></span>
                              </div>
                          </div>
                          <div class="card-body">
                              <?php if(!empty($aula['sala'])): ?>
                                  <div class="mb-2 text-muted small">
                                      <i class="bi bi-geo-alt-fill text-danger"></i> <strong>Sala:</strong> <?= htmlspecialchars($aula['sala']) ?>
                                  </div>
                              <?php endif; ?>

                              <p class="card-text mb-2"><?= nl2br(htmlspecialchars($aula['conteudo'])) ?></p>
                              
                              <?php if($aula['tem_atividade']): ?>
                                  <div class="mb-2"><span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle"></i> Possui atividade / aviso</span></div>
                              <?php endif; ?>

                              <?php if(!empty($aula['imagem_anexo'])): ?>
                                  <a href="uploads/<?= htmlspecialchars($aula['imagem_anexo']) ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                      <i class="bi bi-image"></i> Ver Anexo/Lousa
                                  </a>
                              <?php endif; ?>
                          </div>
                          <div class="card-footer bg-white text-muted small">
                              Prof. <?= htmlspecialchars($aula['professor']) ?>
                          </div>
                      </div>
                  </div>
              <?php endforeach; ?>
          <?php endif; ?>
      </div>
  </div>

</div>

<!-- MODAL DE DETALHES DO EVENTO / AULA DO CALENDÁRIO -->
<div class="modal fade" id="modalDetalhes" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalTitle">Detalhes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBody">
        <!-- Conteúdo preenchido via JavaScript -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- SCRIPT DE INICIALIZAÇÃO DO FULLCALENDAR E EXPORTAÇÃO EXCEL -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var modalElement = new bootstrap.Modal(document.getElementById('modalDetalhes'));
    
    // Identifica se a tela é mobile
    var isMobile = window.innerWidth <= 768;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: isMobile ? 'listWeek' : 'dayGridMonth',
        // Define a data inicial do calendário com a data de início do semestre
        initialDate: '<?= $data_inicial_calendario ?>',
        locale: 'pt-br',
        height: isMobile ? 'auto' : 650,
        
        // Customização da Toolbar (Ajustada para Mobile e Desktop)
        headerToolbar: isMobile ? {
            left: 'prev,next',
            center: 'title',
            right: 'listWeek,dayGridMonth,excelBtn'
        } : {
            left: 'prev,next today excelBtn',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        
        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            list: 'Lista'
        },

        // Botão customizado para baixar o Excel
        customButtons: {
            excelBtn: {
                text: 'Excel',
                click: function() {
                    exportarParaExcel();
                }
            }
        },

        events: 'api/api_eventos.php?semestre_id=<?= $semestre_id ?>',
        
        eventClick: function(info) {
            var props = info.event.extendedProps;
            var html = '';

            if (props.tipo === 'aula') {
                document.getElementById('modalTitle').innerText = 'Diário de Aula - ' + props.materia;
                
                html += '<p><strong><i class="bi bi-person"></i> Professor:</strong> ' + props.professor + '</p>';
                if (props.horario) {
                    html += '<p><strong><i class="bi bi-clock"></i> Horário:</strong> ' + props.horario + '</p>';
                }
                if (props.sala) {
                    html += '<p><strong><i class="bi bi-geo-alt"></i> Sala:</strong> ' + props.sala + '</p>';
                }
                if (props.conteudo) {
                    html += '<hr><p><strong>Conteúdo Lançado:</strong></p><p class="bg-light p-2 rounded">' + props.conteudo.replace(/\n/g, '<br>') + '</p>';
                }
                
                if (props.tem_atividade) {
                    html += '<div class="alert alert-warning py-1 px-2 small"><i class="bi bi-exclamation-circle"></i> Possui atividade pendente/aviso</div>';
                }
                if (props.imagem_anexo) {
                    html += '<a href="uploads/' + props.imagem_anexo + '" target="_blank" class="btn btn-sm btn-primary w-100 mt-2"><i class="bi bi-image"></i> Ver Anexo/Lousa</a>';
                }
            } else {
                document.getElementById('modalTitle').innerText = (props.categoria || 'Evento') + ' - ' + props.materia;
                html += '<p><strong>Descrição:</strong> ' + (props.descricao || 'Sem descrição fornecida.') + '</p>';
            }

            document.getElementById('modalBody').innerHTML = html;
            modalElement.show();
        }
    });

    // Renderiza o calendário
    calendar.render();

    // Redimensiona o calendário se o usuário alternar para a aba do Diário e voltar
    var calendarTab = document.getElementById('calendario-tab');
    if (calendarTab) {
        calendarTab.addEventListener('shown.bs.tab', function () {
            calendar.updateSize();
        });
    }

    // Função JavaScript para ler os eventos do Calendário e Exportar em Excel
    function exportarParaExcel() {
        var eventos = calendar.getEvents();

        if (eventos.length === 0) {
            alert('Nenhum evento para exportar!');
            return;
        }

        var dados = eventos.map(function(e) {
            var props = e.extendedProps || {};
            
            // Trata data e horário
            var dataInicio = e.start ? e.start.toLocaleDateString('pt-BR') : '';
            var horaInicio = e.start ? e.start.toLocaleTimeString('pt-BR', {hour: '2-digit', minute:'2-digit'}) : '';

            return {
                'Título': e.title,
                'Data': dataInicio,
                'Horário': props.horario || horaInicio,
                'Matéria': props.materia || '',
                'Professor': props.professor || '',
                'Sala': props.sala || '',
                'Tipo/Categoria': props.tipo === 'aula' ? 'Diário de Aula' : (props.categoria || 'Evento'),
                'Detalhes/Conteúdo': props.conteudo || props.descricao || ''
            };
        });

        // Cria a planilha usando a biblioteca SheetJS
        var worksheet = XLSX.utils.json_to_sheet(dados);
        var workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Calendario");

        // Baixa o arquivo Excel
        XLSX.writeFile(workbook, "calendario_academico.xlsx");
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>