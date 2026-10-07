-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql200.infinityfree.com
-- Tempo de geração: 07/10/2026 às 19:35
-- Versão do servidor: 11.4.13-MariaDB
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
(15, 8, '2026-08-14', '1ª Aula', NULL, NULL, 'Sala 06', 'Introdução a matéria. Sujeito, substantivo e conjugação de verbo.\r\n\r\nVídeo Aula\r\nhttps://youtu.be/bjgFgX2494E', 0, '', '2026-08-17 18:00:10'),
(16, 9, '2026-08-14', '2ª Aula', NULL, NULL, 'Sala 06', 'Introdução aos conceitos de Contabilidade Geral.', 0, NULL, '2026-08-17 18:01:58'),
(18, 2, '2026-08-17', '1ª Aula', NULL, NULL, 'Laboratório de Informática 01', 'Introdução a Funções e Fórmulas Excel', 0, NULL, '2026-08-17 22:38:05'),
(19, 3, '2026-08-17', '2ª Aula', NULL, NULL, 'Laboratório de Informática 01', 'Conceitos Básicos\r\nEvolução da sociedade e revoluções industrias\r\n\r\nLista de Exercícios em anexo. (A professora irá corrigir e chamar pessoas sorteadas para responder 24/08/2026).\r\n\r\nhttps://youtu.be/IBdSSx8XIYY?si=v7lSVu_uItcXcRtc', 1, '6a848348e378f.jpeg', '2026-08-18 00:23:39'),
(21, 10, '2026-08-04', '1ª Aula', NULL, NULL, 'Sala 06', 'Presença da aula Projeto Integrador \r\nAviso: Adiantamento das aulas (Dia 8 e 15) não terá aula', 0, NULL, '2026-08-18 00:30:45'),
(22, 4, '2026-08-18', '1ª e 2ª Aulas', NULL, NULL, 'Laboratório de Informática 05 e Sala 06', 'Formação dos grupos para o Projeto Integrador e divisão dos conteúdos (empréstimo na biblioteca das referencias bibliográficas de livros com base no siga) para a confecção do trabalho para entrega no final do 1° semestre.\r\n\r\nSegue Exemplo/Ajudas:\r\nhttps://drive.google.com/drive/folders/1xONBiRT3uv8Lwr9SMPwQpWGI79wf7i1Z?usp=sharing', 1, '', '2026-08-18 22:29:50'),
(23, 6, '2026-08-19', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Exercícios de Matemática \r\nTeoria dos conjuntos.\r\n.\r\n.\r\nhttps://drive.google.com/drive/folders/1QFDYMeZycemu15UO3CBzFom8WARWupGW?usp=sharing\r\n(Enviar no Teams)', 1, '', '2026-08-20 19:50:48'),
(24, 4, '2026-08-20', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Substituição da aula da Nirley. Escolha dos temas do seminário e grupos para apresentação. O nosso era o grupo 3. (apresentação dia 08/09/2026)\r\n\r\nhttps://drive.google.com/drive/folders/1gqmr4lezIIAPJkteh3pEm__kSk_G188g?usp=sharing\r\n\r\nhttps://centropaulasouza.sharepoint.com/:w:/r/sites/AdministracaoGeral-A1033-N-GESTAOEMPRESARIAL-178-20262/_layouts/15/Doc.aspx?action=edit&sourcedoc=%7Ba5dfd44d-42e7-4d8c-8677-93a960fc08af%7D&wdExp=TEAMS-TREATMENT&web=1', 1, '', '2026-08-21 14:55:39'),
(25, 8, '2026-08-21', '1ª Aula', NULL, NULL, 'Sala 06', 'Atividade para entregar na próxima sexta 28/08/2026:\r\n- Escrever os verbos no caderno e pronunciar em voz alta do vídeo anexado\r\n\r\nhttps://youtu.be/bjgFgX2494E?is=HpnoxdhNbpK9hCzl\r\n\r\nAula foi sobre conjugação de verbo e predicados/infinitivo.', 1, '', '2026-08-23 22:19:30'),
(26, 9, '2026-08-21', '2ª Aula', NULL, NULL, 'Sala 06', 'Lista de exercícios anexados para entregar dia sexta 28/08/2026:\r\n\r\nhttps://drive.google.com/drive/folders/1NCYIdn3ghlYm55GJmOCRaCmNy6iJyyLi', 1, '', '2026-08-23 22:22:42'),
(27, 2, '2026-08-24', '1ª Aula', NULL, NULL, 'Laboratório de Informática 01', 'Funções Financeiras Excel\r\n\r\nJuros - Simples\r\n\r\nJuros - Composto\r\n\r\nJuros 10% (R$5000 -> R$5500)\r\n\r\n\r\nUma pessoa quer acumlar R$5000 000,00 para isso irá depositar R$ 5000 mensalmente por 20 anos em um fundo que rende 1,17% a.m. Qual o depósito inicial (VP)?\r\n\r\nR: =VP(1,17%; 240; -5000; 5000000; 0)\r\n\r\n\r\n\r\n=NPER(1,5%;0;-2000;20000)\r\n\r\n=PGTO(0,9%;12;5000)', 0, '', '2026-08-24 22:47:10'),
(28, 3, '2026-08-24', '2ª Aula', NULL, NULL, 'Laboratório de Informática 01', 'Atividade documento anexado (Nosso tema é Máquinas Musculares)\r\n\r\nA tarefa dos grupos não será apenas resumir a parte correspondente do texto. O objetivo\r\nserá identificar como a autora caracteriza aquela forma de relação entre o ser humano\r\ne a máquina. Durante a leitura, o grupo deverá localizar informações que permitam\r\nresponder às seguintes questões:\r\n1. Que capacidade humana essas máquinas imitam, prolongam ou ampliam?\r\nIdentifiquem qual dimensão humana está principalmente relacionada àquele nível: força e\r\nmovimento, sentidos ou capacidades mentais.\r\n2. O que essas máquinas permitem que o ser humano passe a fazer de maneira\r\ndiferente?\r\nProcurem perceber se a máquina substitui uma atividade, amplia uma capacidade, registra\r\ninformações, processa símbolos ou modifica de outra maneira a ação humana.\r\n3. Quais exemplos a autora apresenta?\r\nLocalizem exemplos de máquinas, equipamentos ou tecnologias utilizados por Santaella\r\npara explicar o nível analisado.\r\n\r\n4. O que muda na relação entre o ser humano e a máquina na fase que o grupo está\r\nestudando?\r\n\r\nhttps://drive.google.com/drive/folders/1371oPcMKIfJEGcjA9PXBK5ZEVyFbPbET?usp=sharing\r\n\r\nhttps://centropaulasouza-my.sharepoint.com/:w:/r/personal/caroline_nunes3_aluno_cps_sp_gov_br/_layouts/15/Doc.aspx?sourcedoc=%7B39C30FD5-DD56-406E-808C-A2E7A4C5223D%7D&file=Document%202.docx&action=default&mobileredirect=true\r\n\r\nFazer a discussão na primeira aula e na segunda a gente apresenta (Apresentação 31/08/2026)', 1, '', '2026-08-25 00:24:17'),
(29, 4, '2026-08-25', '1ª e 2ª Aulas', NULL, NULL, 'Laboratório de Informática 01 e Sala 06', 'Conteúdo da aula:\r\nhttps://drive.google.com/drive/folders/1JboNIG4v9_bxL9nMP7vXcOEfJ-FknwZ-?usp=sharing\r\n\r\nA Amabile deixou a aula dedicada para fazer atividades e trabalhos pendentes. Avisou que a aula de quinta 27/08/2026 será on-line, não sendo necessário vir para a faculdade.', 0, '', '2026-08-25 18:46:58'),
(30, 6, '2026-08-26', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Continuação conjuntos numérico\r\nExplorando Operações Aritméticas \r\nAlgébrica, problemas e equações \r\n\r\nExplorando os |N e |Z', 0, '6a8f766182959.jpg', '2026-08-26 23:27:29'),
(31, 10, '2026-08-27', '1ª e 2ª Aulas', NULL, NULL, 'Online Teams.', 'Aula online (Não teve chamada), Amabile passou trabalho sobre PI.', 1, NULL, '2026-08-31 11:46:38'),
(32, 8, '2026-08-28', '1ª Aula', NULL, NULL, 'Sala de Aula 06', 'tarefa \r\n1. assistir e treinar sem pausar o vídeo, treinar significa ler junto com o vídeo sem pausar, leitura em voz alta e responder exatamente o que o vídeo está pedindo. SEM PAUSAR - ou seja, solta fala a frase inteira junto com o vídeo e antes da próxima frase fala o nome do verbo usado, tudo sem pausar, o vídeo inteiro . \r\n2. ⁠depois, rever o vídeo, ir pausando e escrever no caderno cada frase , \r\n3. ⁠abaixo de cada frase , depois que escrever todas anote , no caderno, com S de sujeito e V de verbo e responda qual o sujeito o sujeito e qual verbo foi usado em cada uma das frases. \r\n4. ⁠faça isso com todas as frases do vídeo\r\n5. ⁠visto próx aula \r\n\r\nlink https://www.youtube.com/watch?v=MSwFNfj1WUk', 1, NULL, '2026-08-31 22:42:04'),
(33, 9, '2026-08-28', '2ª Aula', NULL, NULL, 'Sala de Aula 06', 'Atividade para fazer no caderno\r\nFoto da apostila enviada no grupo no dia 28/08\r\nEntregar dia 04/09', 1, NULL, '2026-08-31 22:52:01'),
(34, 2, '2026-08-31', '1ª Aula', NULL, NULL, 'Laboratório de Informática 01.', 'Atividades teams para entregar 14/09/2026 e 21/09/2026.', 1, '6a960b3c2d268.png', '2026-08-31 23:16:12'),
(35, 6, '2026-09-02', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Conjuntos números e operações com intervalo.\r\n\r\nhttps://drive.google.com/drive/folders/1xlknfpWcsBhlw-N0KpH72l-lC4xGXosO', 0, NULL, '2026-09-03 23:49:30'),
(36, 8, '2026-09-04', '2ª Aula', NULL, NULL, 'Sala 06', 'Correção da atividade da última aula. Atividade em grupo, leitura e interpretação de texto.', 1, NULL, '2026-09-05 22:49:00'),
(37, 9, '2026-09-04', '2ª Aula', NULL, NULL, 'Sala 06', 'Aula vaga.', 0, NULL, '2026-09-05 22:49:15'),
(38, 7, '2026-09-03', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Retorno Nirley.', 0, '', '2026-09-05 22:51:35'),
(39, 4, '2026-09-08', '1ª e 2ª Aulas', NULL, NULL, 'Laboratório de Informática 05 e Sala 06', 'Apresentação dos Trabalhos sobre Teoria da Administração Geral.', 0, NULL, '2026-09-09 17:52:28'),
(40, 10, '2026-09-05', '1ª e 2ª Aulas', NULL, NULL, 'Teams', 'Primeira aula de projeto integrador Teams.', 1, NULL, '2026-09-09 17:52:53'),
(41, 6, '2026-09-09', '1ª e 2ª Aulas', NULL, NULL, 'Sala de Aula 06', 'Exercício- Problemas sobre quantidade\r\nProva 1 dia', 0, NULL, '2026-09-09 22:40:46'),
(42, 6, '2026-09-09', '1ª e 2ª Aulas', NULL, NULL, 'Sala de Aula 06', 'Exercício - Problemas com quantidades\r\nProva dia 30/09 \r\n\r\nLISTA DE EXERCÍCIO NO TEAMS PARA RESOLVER E ENTREGAR DIA 29/09', 1, NULL, '2026-09-09 22:41:44'),
(43, 7, '2026-09-10', '1ª e 2ª Aulas', NULL, NULL, 'Sala de Aula 06', 'Atividade em dupla adiada por conta da chuva\r\nNão foi passado nada de importante apenas falta', 0, NULL, '2026-09-13 21:17:41'),
(44, 8, '2026-09-11', '1ª Aula', NULL, NULL, 'Sala de Aula 06', 'Suspensão da aula por conta da chuva', 0, NULL, '2026-09-13 21:18:27'),
(45, 9, '2026-09-11', '2ª Aula', NULL, NULL, 'Sala de Aula 06', 'Suspensão da aula por conta da chuva', 0, NULL, '2026-09-13 21:18:50'),
(46, 10, '2026-09-12', '1ª Aula', NULL, NULL, 'Teams', 'Dia 26/09 Entrega dos words \"Papel do Gestor\" e Breafing pessoal\"', 1, NULL, '2026-09-13 21:19:46'),
(47, 2, '2026-09-14', '1ª Aula', NULL, NULL, 'Laboratório de Informática 06', 'Aula Atividade\r\nEnsinando a fazer a Atividade Prática 02 - Tabela Dinâmica', 1, NULL, '2026-09-14 22:56:09'),
(48, 4, '2026-09-15', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Para apresentar dia 29/09\r\nRoteiro ambiente externo tecnológico, como a tecnologia influencia as empresas e o mercado (forças tecnológicas)', 1, '', '2026-09-21 16:30:14'),
(49, 6, '2026-09-16', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Aula dedicada para fazer os exercícios do teams (Que vão cair na prova).', 0, NULL, '2026-09-21 16:31:00'),
(50, 3, '2026-09-14', '2ª Aula', NULL, NULL, 'Laboratório de Informática 01', 'Aula dedicada a apresentação dos trabalhos sobre o homem e máquina.', 0, NULL, '2026-09-21 16:33:39'),
(51, 7, '2026-09-17', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Apresentação, conteúdo apresentado se encontra no teams.', 0, NULL, '2026-09-21 16:34:18'),
(52, 9, '2026-09-18', '2ª Aula', NULL, NULL, 'Sala 06', 'Aula sobre Razonetes e Balancetes, passou atividade.', 1, NULL, '2026-09-21 16:38:12'),
(53, 8, '2026-09-18', '1ª Aula', NULL, NULL, 'Sala 06', '.', 0, NULL, '2026-09-21 16:41:10'),
(54, 10, '2026-09-19', '1ª Aula', NULL, NULL, 'Teams', 'Não teve aula no teams nessa data', 0, NULL, '2026-09-23 14:24:38'),
(55, 2, '2026-09-21', '1ª Aula', NULL, NULL, 'Lab Inf 01', 'Exercício no Teams\r\n\r\nQuiz de Excel: Funções, Est e Op\r\n\r\nPlanilha para resolver no Teams\r\nAtividade I - Exel', 1, NULL, '2026-09-23 14:26:22'),
(56, 3, '2026-09-21', '2ª Aula', NULL, NULL, 'Lab Inf 01', 'Redação ou Texto para o dia 05/10 sobre\r\nDefesa estritamente a tecnologia que esta sendo proposta \r\nD de forma crítica \r\nD de forma equilibrada \r\n\r\nTerminio da apresentação \"As Maquinas Musculo\"\r\nEntrega da atividade contando presença \r\nMaterial da aula 12/09', 0, NULL, '2026-09-23 14:30:57'),
(57, 4, '2026-09-22', '1ª e 2ª Aulas', NULL, NULL, 'Lab Inf 01 e Sala 6', 'Entrega do trabalho Declaração Institucional \r\nResumir em um PDF qualquer empresa que voce quiser destacando sua Missão, Visão e Valores e entregar no teams em uma pasta compartilhada', 1, '', '2026-09-23 14:59:56'),
(58, 6, '2026-09-23', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Equação e Inequação de 1° Grau. Lista de exercícios parar entregar dia 28/09/2026.', 1, '', '2026-09-24 22:39:06'),
(59, 7, '2026-09-24', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06', 'Atividade de apresentação, escolha uma empresa e faça um powerpoint como se fosse um colaborador. Mais detalhes no teams. Entrega dia 01/10/26.', 1, NULL, '2026-09-26 11:53:33'),
(60, 8, '2026-09-25', '1ª Aula', NULL, NULL, 'Sala 06.', 'Tipologia das frases. Afirmativa, negativa e interrogativa.', 0, '', '2026-09-26 13:53:42'),
(61, 9, '2026-09-25', '2ª Aula', NULL, NULL, 'Sala 06', 'Razonetes e Balancete. Atividade pré-prova.', 1, NULL, '2026-09-28 14:04:21'),
(62, 10, '2026-09-26', '1ª Aula', NULL, NULL, 'Teams', 'Entrega dos trabalhos de PI\r\nDados da Empresa \r\nEntrevista Gestor\r\nReferêncial Teórico \r\nRoteiro Briefing', 0, NULL, '2026-09-29 23:28:50'),
(63, 2, '2026-09-28', '1ª Aula', NULL, NULL, 'Laboratório de Informática 01', 'Resolução de como fazer os Exercícios do Atividade I - Excel', 0, NULL, '2026-09-29 23:32:47'),
(64, 7, '2026-09-28', '2ª Aula', NULL, NULL, 'Sala de Aula 07', 'Prova P1', 0, NULL, '2026-09-29 23:33:24'),
(65, 4, '2026-09-29', '1ª e 2ª Aulas', NULL, NULL, 'Lab Inf 5 e Sala de Aula 06', 'Apresentação do Trabalho (MacroAmbiente) Roteiro ambiente externo tecnológico, como a tecnologia influencia as empresas e o mercado (forças tecnológicas)', 0, NULL, '2026-09-29 23:35:10'),
(66, 6, '2026-09-30', '1ª e 2ª Aulas', NULL, NULL, 'Sala 06.', 'Aula exclusivamente dedicada a prova.', 0, '', '2026-10-01 12:50:10'),
(67, 9, '2026-10-02', '2ª Aula', NULL, NULL, 'Sala 06', 'Aula exclusivamente dedicada a prova.', 0, NULL, '2026-10-05 12:38:32');

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
(6, 3, '2026-12-14', 'Trabalho', 'Seminário'),
(7, 4, '2026-09-01', 'Outro', 'Aula Magna'),
(8, 2, '2026-09-07', 'Outro', 'Feriado.'),
(9, 7, '2026-09-07', 'Outro', 'Feriado.'),
(10, 6, '2026-09-30', 'Prova', 'Prova 1'),
(11, 9, '2026-10-02', 'Prova', 'Prova P1.'),
(12, 9, '2026-09-18', 'Outro', 'Margarete comunicou que está de saída da FATEC até outubro. Até o momento seguimos sem professor subtituto.'),
(13, 9, '2026-10-09', 'Prova', 'P2.');

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
(4, 1, 'Administração Geral', NULL, 'AMABILE CRISTINA BRUGNARO', '', NULL, 'Terça'),
(6, 1, 'Matemática', NULL, 'Bruno Henrique', '', NULL, 'Quarta'),
(7, 1, 'Comunicação e Expressão', NULL, 'NIRLEI SANTOS DE LIMA', '', NULL, 'Quinta'),
(8, 1, 'Inglês I', NULL, 'EDSON MENDES', '', NULL, 'Sexta'),
(9, 1, 'Contabilidade', NULL, 'MARGARETE GURNIAK', '', NULL, 'Sexta'),
(10, 1, 'Projeto Integrador em Gestão Empresarial I', NULL, 'AMABILE CRISTINA BRUGNARO SANTOS', '', NULL, 'Sábado');

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
(2, 'Divulgação Estágio Guarany', 'Estágio Obrigatório', 'Oportunidade de estágio. CADASTREM O CURRICULO:\r\nhttps://www.guaranyind.com.br/\r\ntrabalhe conosco', 'Estágio/Vaga', '2026-07-30', 'noticia_6a7a135f11a2d.png', 0, 'publicado', 1, '2026-08-10 18:07:27', '2026-08-18 16:24:11'),
(4, 'Vaga na equipe de TCC', 'Vaga Gestão Empresarial', 'Estamos com o projeto do nosso TCC \r\n💡 Buscamos +1 integrante que queira somar em:\r\n\r\n-Redação e estrutura da documentação (Normas ABNT);\r\n-Apoio em testes de sistema e regras de negócio.\r\n\r\nSe você está sem grupo ou quer fechar uma equipe chama no Teams! 📥\r\nGustavo Munhoz Pivato ou Gustavo Alves Menezes Lopes', 'Estágio/Vaga', '2026-07-29', 'noticia_6a7a1c8b1d41c.png', 0, 'publicado', 3, '2026-08-10 18:46:35', '2026-08-10 22:41:58'),
(5, 'ACC Horas Complementares Obrigatórias - Gestão Empresarial', 'ACC', 'Atenção, alunos de Gestão Empresarial da Fatec Itu: de acordo com a Portaria FATEC ITU nº 001/2024, é obrigatória a comprovação de no mínimo 40 horas de Atividades Acadêmico-Científico-Culturais (AACC) até o final do 5º semestre do curso, mediante a entrega da Ficha de Acompanhamento preenchida e acompanhada das cópias dos comprovantes na Secretaria Acadêmica. Fiquem atentos aos prazos e às atividades válidas (como cursos de extensão, eventos científicos, trabalhos voluntários e visitas técnicas), pois o não cumprimento das horas exigidas acarreta a retenção do estudante no curso até a sua totalização.\r\n\r\nhttps://drive.google.com/drive/folders/1nCdTIH2pyHcRseeoh4OcH2R-F3bfVi7K?usp=sharing', 'Aviso Institucional', '2026-08-18', NULL, 1, 'publicado', 1, '2026-08-18 16:16:37', '2026-08-18 16:16:37'),
(7, 'Grade 1° Semestre', 'Horários e Salas', 'Segue grade atual referente ao 1° Semestre do curso de Gestão Empresarial.', 'Noticia', '2026-08-25', 'noticia_6a8e25277838b.jpeg', 0, 'publicado', 1, '2026-08-25 23:25:42', '2026-08-25 23:28:38'),
(8, 'Cancelamento Aulas 11/09/26', 'Alerta defesa civil', 'Cancelamento das aulas 11/09/26 devido as fortes chuvas regionais. Aula de comunicação e expressão.', 'Noticia', '2026-09-11', 'noticia_6aa7e9cf598e0.png', 0, 'publicado', 1, '2026-09-14 12:34:23', '2026-09-14 12:35:18');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de tabela `eventos_calendario`
--
ALTER TABLE `eventos_calendario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `noticias_eventos`
--
ALTER TABLE `noticias_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
