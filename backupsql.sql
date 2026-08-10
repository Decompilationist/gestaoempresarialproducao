-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql200.infinityfree.com
-- Tempo de geração: 10/08/2026 às 14:04
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
(7, 10, '2026-08-08', '1ª e 2ª Aulas', NULL, NULL, 'Teams', 'Primeiro projeto integrador do semestre.', 0, NULL, '2026-08-07 19:59:57'),
(8, 9, '2026-08-07', '2ª Aula', NULL, NULL, 'Sala 06', 'Apresentação da Matéria. Não teve chamada.', 0, '', '2026-08-08 00:10:25');

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
(2, 8, '2026-08-07', 'Prova', 'Prova de Proficiência de Inglês (Avaliação Nível).');

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
(10, 1, 'Projeto Integrador em Gestão Empresarial I', NULL, '?', '', NULL, 'Segunda');

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
(1, '1° Semestre', '2026-08-03', '2026-12-31', 1, '2026-08-07 16:00:25'),
(2, '2° Semestre', '2027-02-01', '2027-07-31', 1, '2026-08-07 16:00:41'),
(3, '3° Semestre', '2027-08-02', '2027-12-31', 1, '2026-08-07 16:00:48'),
(4, '4° Semestre', '2028-02-01', '2028-07-31', 1, '2026-08-07 16:00:53'),
(5, '5° Semestre', '2028-08-01', '2028-12-31', 1, '2026-08-07 16:00:57'),
(6, '6° Semestre', '2029-02-01', '2029-07-31', 1, '2026-08-07 16:01:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `eventos_calendario`
--
ALTER TABLE `eventos_calendario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `noticias_eventos`
--
ALTER TABLE `noticias_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `semestres`
--
ALTER TABLE `semestres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
