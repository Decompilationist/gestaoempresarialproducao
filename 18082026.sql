-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql200.infinityfree.com
-- Tempo de geração: 17/08/2026 às 23:07
-- Versão do servidor: 11.4.12-MariaDB
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `if0_42602920_fatec_gestao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `diario_aulas`
--

CREATE TABLE `diario_aulas` (
  `id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `data_aula` date NOT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `horario_inicio` time DEFAULT NULL,
  `horario_fim` time DEFAULT NULL,
  `sala` varchar(50) DEFAULT NULL,
  `conteudo` text NOT NULL,
  `tem_atividade` tinyint(1) DEFAULT 0,
  `imagem_anexo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `diario_aulas`
--

INSERT INTO `diario_aulas` (`id`, `materia_id`, `data_aula`, `horario`, `horario_inicio`, `horario_fim`, `sala`, `conteudo`, `tem_atividade`, `imagem_anexo`, `created_at`) VALUES
(1, 2, '2026-08-03', '2ª Aula', NULL, NULL, 'Auditório', 'Palestra e recebimento dos calouros.', 0, '', '2026-08-07 16:11:05'),
(2, 3, '2026-08-03', '1ª Aula', NULL, NULL, 'Auditório', 'Palestra e recebimento dos calouros.', 0, '', '2026-08-07 16:11:28'),
(4, 4, '2026-08-04', '1ª e 2ª Aulas', NULL, NULL, 'Auditório', 'Palestra sobre inteligência artificial e tour pelo polo.', 0, '', '2026-08-07 16:19:21'),
(5, 6, '2026-08-05', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Introdução ao procedimento das aulas. Conteúdos que teremos esse semestre: Noções de lógica (preposições, conectivos e linguagem lógica). Noções da Teoria dos Conjuntos (Conceitos Básicos, Representações, Operações e Conectores Lógicos, Conjuntos Numéricos); Noções sobre Conjuntos Numéricos; Operações com os Números Racionais na forma fracionária e Decimal; Regra de Três; Cálculos de Porcentagem; Potenciação e Radiação; Operações Algébricas com Polinômios, Fatoração e Produtos Notáveis; Equações e Inequações com representação algébricas e Gráficas do 1° e 2° Grau; Sistemas Lineares (Escalonamento); Logaritmos; Funções do 1° e 2° Grau, Exponenciais; Progressões Aritméticas e Geométricas. ', 0, NULL, '2026-08-07 16:26:43'),
(6, 7, '2026-08-06', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Introdução e apresentação da matéria. Atividade do dia: Produção Textual - Projete-se Quem é você e onde quer chegar? Teve visto no mesmo.', 1, NULL, '2026-08-07 16:28:37'),
(8, 9, '2026-08-07', '2ª Aula', NULL, NULL, 'Sala 06', 'Apresentação da Matéria. Não teve chamada.', 0, '', '2026-08-08 00:10:25'),
(9, 2, '2026-08-10', '1ª Aula', NULL, NULL, 'Laboratório de Informática 1', 'Inicialização da matéria: Ensinando a como se utilizar o Office\r\n\r\nE-mail do professor: renato.cardos@cps.sp.gov.br\r\nInformática Aplicado\r\n\r\nSite do Office\r\nhttps://www.office.com\r\n\r\nOffice/Teams\r\n- Matemática Financeira\r\n- %\r\n- Funções (Se, Somase, Procv ...)\r\n- Gráficos/Impressão/Tabela Dinâmica\r\n\r\nPower BI\r\n- Análise de PBI\r\n- Recursos\r\n- Dashboard\r\n\r\n-Word (Trabalhos)\r\n- Power Point\r\n\r\nFerramentas de Ia\r\n- Aprender a criar um agente de IA no final do curso\r\n\r\nAvaliações = (P1+ P2 + P3 + P4 /4) * 0,9 + (Projeto integrador) * 0,1 || Aprovação min. 6,0', 0, '', '2026-08-10 22:13:11'),
(11, 3, '2026-08-10', '2ª Aula', NULL, NULL, 'Laboratório de informática 1', 'Atividade em grupo da disciplina de Sociedade, Tecnologia e Inovação (Profa. Daniele Torres): análise de um estudo de caso sobre os impactos sociais, culturais e tecnológicos da automação e da Inteligência Artificial na empresa Conecta Gestão, com elaboração e entrega via Teams de um relato escrito de cerca de 1 página contendo os nomes dos 5 integrantes, a problematização da cultura organizacional e uma proposta de decisão ética e responsável. (Plataforma Teams)', 1, '', '2026-08-10 22:51:25'),
(12, 4, '2026-08-11', '2ª Aula', NULL, NULL, 'Laboratório de informática 5 e Sala 06', 'Atividade de classificação pessoal. Descreva sua missão, visão e valores.', 1, '', '2026-08-12 22:21:25'),
(13, 6, '2026-08-12', '2ª Aula', NULL, NULL, 'Sala 06', 'Introdução a Matemática básica, conjuntos numéricos. Atividade de conversão de decimais e fração.', 1, '6a7cfcc008b81.jpeg', '2026-08-12 23:07:44'),
(14, 10, '2026-08-13', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Confraternização e lista de presença para sábado projeto integrador.', 0, '', '2026-08-14 02:00:47'),
(15, 8, '2026-08-14', '1ª Aula', NULL, NULL, 'Sala 06', 'Introdução a matéria. Sujeito, substantivo e conjugação de verbo.', 0, NULL, '2026-08-17 18:00:10'),
(16, 9, '2026-08-14', '2ª Aula', NULL, NULL, 'Sala 06', 'Introdução aos conceitos de Contabilidade Geral.', 0, NULL, '2026-08-17 18:01:58'),
(18, 2, '2026-08-17', '1ª Aula', NULL, NULL, 'Laboratório de Informática 01', 'Introdução a Funções e Fórmulas Excel', 0, NULL, '2026-08-17 22:38:05'),
(19, 3, '2026-08-17', '2ª Aula', NULL, NULL, 'Laboratório de Informática 01', 'Conceitos Básicos\r\nEvolução da sociedade e revoluções industrias\r\n\r\nhttps://youtu.be/IBdSSx8XIYY?si=v7lSVu_uItcXcRtc', 1, '', '2026-08-18 00:23:39'),
(20, 10, '2026-08-22', '1ª Aula', NULL, NULL, 'Teams', 'Primeira aula do Projeto Integrador no Teams\r\nTeams: https://teams.cloud.microsoft/', 0, '', '2026-08-18 00:27:11'),
(21, 10, '2026-08-04', '1ª Aula', NULL, NULL, 'Sala 06', 'Presença da aula Projeto Integrador \r\nAviso: Adiantamento das aulas (Dia 8 e 15) não terá aula', 0, NULL, '2026-08-18 00:30:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos_calendario`
--

CREATE TABLE `eventos_calendario` (
  `id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `data_evento` date NOT NULL,
  `tipo` enum('Prova','Trabalho','Projeto Integrador','Outro') NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `eventos_calendario`
--

INSERT INTO `eventos_calendario` (`id`, `materia_id`, `data_evento`, `tipo`, `descricao`) VALUES
(1, 7, '2026-08-06', 'Outro', 'Nirlei avisou que entrará de licença médica devido a uma cirurgia e só voltará em setembro. Amabile ficará responsável pelas suas aulas no período.'),
(2, 8, '2026-08-07', 'Prova', 'Prova de Proficiência de Inglês (Avaliação Nível).'),
(3, 7, '2026-08-13', 'Outro', 'Café e apresentação do projeto integrador dos alunos do 2 semestre.'),
(4, 3, '2026-09-28', 'Prova', 'Prova P1'),
(5, 3, '2026-11-30', 'Prova', 'Prova P2'),
(6, 3, '2026-12-14', 'Trabalho', 'Trabalho SUB');

-- --------------------------------------------------------

--
-- Estrutura para tabela `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `semestre_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `professor` varchar(100) DEFAULT NULL,
  `professor_substituto` varchar(100) DEFAULT NULL,
  `sala` varchar(50) DEFAULT NULL,
  `dia_semana` enum('Segunda','Terça','Quarta','Quinta','Sexta','Sábado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `materias`
--

INSERT INTO `materias` (`id`, `semestre_id`, `nome`, `codigo`, `professor`, `professor_substituto`, `sala`, `dia_semana`) VALUES
(2, 1, 'Informática Aplicada a Gestão', NULL, 'RENATO LUIZ CARDOSO', '', NULL, 'Segunda'),
(3, 1, 'Sociedade, Tecnologia e Inovação', NULL, 'DANIELE TORRES LOUREIRO', '', NULL, 'Segunda'),
(4, 1, 'Administração Geral', NULL, 'AMABILE CRISTINA BRUGNARO', '', NULL, 'Segunda'),
(6, 1, 'Matemática', NULL, 'Bruno Henrique', '', NULL, 'Segunda'),
(7, 1, 'Comunicação e Expressão', NULL, 'NIRLEI SANTOS DE LIMA', '', NULL, 'Segunda'),
(8, 1, 'Inglês I', NULL, 'EDSON MENDES', '', NULL, 'Segunda'),
(9, 1, 'Contabilidade', NULL, 'MARGARETE GURNIAK', '', NULL, 'Segunda'),
(10, 1, 'Projeto Integrador em Gestão Empresarial I', NULL, 'AMABILE CRISTINA BRUGNARO SANTOS', '', NULL, 'Segunda');

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias_eventos`
--

CREATE TABLE `noticias_eventos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `conteudo` text NOT NULL,
  `tipo` enum('Noticia','Evento','Aviso Institucional','Palestra','Estágio/Vaga') NOT NULL DEFAULT 'Noticia',
  `data_evento` date DEFAULT NULL,
  `imagem_capa` varchar(255) DEFAULT NULL,
  `fixado` tinyint(1) DEFAULT 0,
  `status` enum('rascunho','publicado') DEFAULT 'publicado',
  `usuario_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `noticias_eventos`
--

INSERT INTO `noticias_eventos` (`id`, `titulo`, `subtitulo`, `conteudo`, `tipo`, `data_evento`, `imagem_capa`, `fixado`, `status`, `usuario_id`, `created_at`, `updated_at`) VALUES
(2, 'Divulgação Estágio Guarany', 'Estágio Obrigatório', 'Oportunidade de estágio. CADASTREM O CURRICULO:\r\nwww.garanyind.com.br trabalhe conosco', 'Estágio/Vaga', '2026-07-30', 'noticia_6a7a135f11a2d.png', 0, 'publicado', 1, '2026-08-10 18:07:27', '2026-08-10 18:10:52'),
(4, 'Vaga na equipe de TCC', 'Vaga Gestão Empresarial', 'Estamos com o projeto do nosso TCC \r\n💡 Buscamos +1 integrante que queira somar em:\r\n\r\n-Redação e estrutura da documentação (Normas ABNT);\r\n-Apoio em testes de sistema e regras de negócio.\r\n\r\nSe você está sem grupo ou quer fechar uma equipe chama no Teams! 📥\r\nGustavo Munhoz Pivato ou Gustavo Alves Menezes Lopes', 'Estágio/Vaga', '2026-07-29', 'noticia_6a7a1c8b1d41c.png', 0, 'publicado', 3, '2026-08-10 18:46:35', '2026-08-10 22:41:58');

-- --------------------------------------------------------

--
-- Estrutura para tabela `semestres`
--

CREATE TABLE `semestres` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `semestres`
--

INSERT INTO `semestres` (`id`, `nome`, `data_inicio`, `data_fim`, `ativo`, `created_at`) VALUES
(1, '1° Semestre', '2026-08-03', '2026-12-31', 1, '2026-08-07 16:00:25');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','aluno') DEFAULT 'aluno',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `perfil`, `created_at`) VALUES
(1, 'Gustavo Alves', 'gustavo.lopes26@aluno.cps.sp.gov.br', '$2y$10$hXw6hkfghytib.goOB1icuobztzINKUytYqIcml4Gd.UHatt4tO1G', 'admin', '2026-08-07 15:41:42'),
(3, 'Gustavo Pivato', 'gustavo.pivato@aluno.cps.sp.gov.br', '$2y$10$hXw6hkfghytib.goOB1icuobztzINKUytYqIcml4Gd.UHatt4tO1G', 'admin', '2026-08-07 15:41:42');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `diario_aulas`
--
ALTER TABLE `diario_aulas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_diario_materia_data` (`materia_id`,`data_aula`);

--
-- Índices de tabela `eventos_calendario`
--
ALTER TABLE `eventos_calendario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materia_id` (`materia_id`),
  ADD KEY `idx_eventos_data` (`data_evento`);

--
-- Índices de tabela `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semestre_id` (`semestre_id`);

--
-- Índices de tabela `noticias_eventos`
--
ALTER TABLE `noticias_eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_noticias_usuario` (`usuario_id`);

--
-- Índices de tabela `semestres`
--
ALTER TABLE `semestres`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `diario_aulas`
--
ALTER TABLE `diario_aulas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `eventos_calendario`
--
ALTER TABLE `eventos_calendario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `noticias_eventos`
--
ALTER TABLE `noticias_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `semestres`
--
ALTER TABLE `semestres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `diario_aulas`
--
ALTER TABLE `diario_aulas`
  ADD CONSTRAINT `diario_aulas_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `eventos_calendario`
--
ALTER TABLE `eventos_calendario`
  ADD CONSTRAINT `eventos_calendario_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`semestre_id`) REFERENCES `semestres` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `noticias_eventos`
--
ALTER TABLE `noticias_eventos`
  ADD CONSTRAINT `fk_noticias_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
