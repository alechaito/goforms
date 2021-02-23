-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 17/01/2021 às 10:15
-- Versão do servidor: 5.7.32-0ubuntu0.16.04.1
-- Versão do PHP: 7.3.18-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cif`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `evaluates`
--

CREATE TABLE `evaluates` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_name` varchar(500) DEFAULT NULL,
  `question_response` varchar(500) DEFAULT NULL,
  `question_type` int(11) NOT NULL,
  `patient_id` int(10) NOT NULL,
  `quiz_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `evaluates`
--

INSERT INTO `evaluates` (`id`, `question_id`, `question_name`, `question_response`, `question_type`, `patient_id`, `quiz_id`) VALUES
(1, 31, 'Faz sons que mostram para você que ele ou ela está feliz ou chateado', '0', 2, 477, 57),
(2, 32, 'Parece feliz em ver você', '2', 2, 398, 57),
(3, 33, 'Segue com os olhos o movimento de um brinquedo', '2', 2, 219, 57),
(4, 34, 'Vira a cabeça para achar a pessoa que está falando', '2', 2, 845, 57),
(5, 35, 'Mantém a cabeça firme quando puxado para sentar', '1', 2, 646, 57),
(6, 36, 'Junta as mãos', '0', 2, 785, 57),
(7, 37, 'Ri', '2', 2, 865, 57),
(8, 38, 'Mantém a cabeça firme quando você o/a segura na posição sentada', '2', 2, 43, 57),
(9, 39, 'Faz sons como "ga", "ma" ou "ba"', '0', 2, 490, 57),
(10, 40, 'Olha quando você o/a chama pelo nome', '0', 2, 920, 57),
(11, 41, 'Sua criança fica incomodada com novas pessoas?', '2', 2, 853, 57),
(12, 42, 'Sua criança fica incomodada em lugares novos?', '0', 2, 28, 57),
(13, 43, 'É difícil para sua criança lidar com mudanças na rotina?', '1', 2, 889, 57),
(14, 44, 'Sua criança fica incomodada de ser carregada por outras pessoas?', '2', 2, 379, 57),
(15, 45, 'Sua criança chora muito?', '2', 2, 338, 57),
(16, 46, 'É difícil para sua criança se acalmar sozinha?', '1', 2, 856, 57),
(17, 47, 'Sua criança fica irritada facilmente?', '0', 2, 361, 57),
(18, 48, 'Sua criança continua chorando, mesmo quando você a pega no colo e tenta acalmá-la?', '1', 2, 518, 57),
(19, 49, 'É difícil manter sua criança nas rotinas do dia a dia?', '2', 2, 451, 57),
(20, 50, 'Sua criança tem dificuldades para pegar no sono?', '2', 2, 192, 57),
(21, 51, 'É difícil para você dormir o suficiente por causa da sua criança?', '2', 2, 911, 57),
(22, 52, 'Sua criança tem dificuldades para manter o sono?', '0', 2, 131, 57),
(23, 53, 'Você tem alguma preocupação com o aprendizado ou com o desenvolvimento dela?', '0', 2, 69, 57),
(24, 54, 'Você tem alguma preocupação com o comportamento de sua criança?', '0', 2, 559, 57),
(25, 55, 'Alguem que mora com sua criança fuma cigarro?', '2', 2, 576, 57),
(26, 56, 'No último ano, alguma vez você consumiu mais álcool ou drogas do que pretendia?', '0', 2, 583, 57),
(27, 57, 'No último ano, você sentiu vontade ou necessidade de diminuir o seu consumo de álcool ou drogas?', '2', 2, 294, 57),
(28, 58, 'Alguma vez, o uso de álcool ou drogas por algum membro da família trouxe consequências negativas para sua criança?', '1', 2, 651, 57),
(29, 59, 'Nos ultimos 12 meses, ficamos preocupados se nossa comida poderia  acabarantes que pudessemos comprar mais.', '0', 2, 699, 57),
(30, 60, 'Em geral, como você descreveria seu relacionamento com seu/sua marido/companheiro(a)?', '3', 2, 134, 57),
(31, 61, 'Você e seu/sua marido/companheiro(a) resolvem seus desentendimentos', '0', 2, 138, 57),
(32, 62, 'Na última semana, quantos dias você ou outro membro da familialeu para sua criança?', '7', 2, 492, 57),
(33, 63, 'Tenho sido capaz d  e me rir e ver o lado divertido das coisas', '0', 2, 63, 57),
(34, 64, 'Tenho tido esperança no futuro', '2', 2, 501, 57),
(35, 65, 'Tenho-me culpado sem necessidade quando as coisas correm mal', '0', 2, 21, 57),
(36, 66, 'Tenho estado ansiosa ou preocupada sem motivo', '1', 2, 835, 57),
(37, 67, 'Tenho-me sentido com medo, ou muito assustada, sem grande motivo', '0', 2, 280, 57),
(38, 68, 'Tenho sentido que são coisas demais para mim', '2', 2, 889, 57),
(39, 69, 'Tenho-me sentido tão infeliz que durmo mal', '1', 2, 994, 57),
(40, 70, 'Tenho-me sentido triste ou muito infeliz', '2', 2, 262, 57),
(41, 71, 'Tenho-me sentido tão infeliz que choro', '1', 2, 468, 57),
(42, 72, 'Tive ideias de fazer mal a mim mesma', '2', 2, 320, 57),
(43, 31, 'Faz sons que mostram para você que ele ou ela está feliz ou chateado', '2', 2, 480, 57),
(44, 32, 'Parece feliz em ver você', '2', 2, 954, 57),
(45, 33, 'Segue com os olhos o movimento de um brinquedo', '0', 2, 948, 57),
(46, 34, 'Vira a cabeça para achar a pessoa que está falando', '2', 2, 683, 57),
(47, 35, 'Mantém a cabeça firme quando puxado para sentar', '0', 2, 824, 57),
(48, 36, 'Junta as mãos', '2', 2, 618, 57),
(49, 37, 'Ri', '2', 2, 173, 57),
(50, 38, 'Mantém a cabeça firme quando você o/a segura na posição sentada', '0', 2, 413, 57),
(51, 39, 'Faz sons como "ga", "ma" ou "ba"', '0', 2, 592, 57),
(52, 40, 'Olha quando você o/a chama pelo nome', '0', 2, 102, 57),
(53, 41, 'Sua criança fica incomodada com novas pessoas?', '0', 2, 555, 57),
(54, 42, 'Sua criança fica incomodada em lugares novos?', '1', 2, 55, 57),
(55, 43, 'É difícil para sua criança lidar com mudanças na rotina?', '1', 2, 881, 57),
(56, 44, 'Sua criança fica incomodada de ser carregada por outras pessoas?', '0', 2, 842, 57),
(57, 45, 'Sua criança chora muito?', '2', 2, 452, 57),
(58, 46, 'É difícil para sua criança se acalmar sozinha?', '1', 2, 839, 57),
(59, 47, 'Sua criança fica irritada facilmente?', '0', 2, 757, 57),
(60, 48, 'Sua criança continua chorando, mesmo quando você a pega no colo e tenta acalmá-la?', '1', 2, 428, 57),
(61, 49, 'É difícil manter sua criança nas rotinas do dia a dia?', '1', 2, 407, 57),
(62, 50, 'Sua criança tem dificuldades para pegar no sono?', '1', 2, 788, 57),
(63, 51, 'É difícil para você dormir o suficiente por causa da sua criança?', '0', 2, 187, 57),
(64, 52, 'Sua criança tem dificuldades para manter o sono?', '1', 2, 27, 57),
(65, 53, 'Você tem alguma preocupação com o aprendizado ou com o desenvolvimento dela?', '0', 2, 897, 57),
(66, 54, 'Você tem alguma preocupação com o comportamento de sua criança?', '0', 2, 951, 57),
(67, 55, 'Alguem que mora com sua criança fuma cigarro?', '2', 2, 386, 57),
(68, 56, 'No último ano, alguma vez você consumiu mais álcool ou drogas do que pretendia?', '2', 2, 946, 57),
(69, 57, 'No último ano, você sentiu vontade ou necessidade de diminuir o seu consumo de álcool ou drogas?', '2', 2, 132, 57),
(70, 58, 'Alguma vez, o uso de álcool ou drogas por algum membro da família trouxe consequências negativas para sua criança?', '0', 2, 903, 57),
(71, 59, 'Nos ultimos 12 meses, ficamos preocupados se nossa comida poderia  acabarantes que pudessemos comprar mais.', '1', 2, 616, 57),
(72, 60, 'Em geral, como você descreveria seu relacionamento com seu/sua marido/companheiro(a)?', '3', 2, 798, 57),
(73, 61, 'Você e seu/sua marido/companheiro(a) resolvem seus desentendimentos', '3', 2, 426, 57),
(74, 62, 'Na última semana, quantos dias você ou outro membro da familialeu para sua criança?', '6', 2, 491, 57),
(75, 63, 'Tenho sido capaz d  e me rir e ver o lado divertido das coisas', '1', 2, 113, 57),
(76, 64, 'Tenho tido esperança no futuro', '3', 2, 721, 57),
(77, 65, 'Tenho-me culpado sem necessidade quando as coisas correm mal', '3', 2, 138, 57),
(78, 66, 'Tenho estado ansiosa ou preocupada sem motivo', '3', 2, 343, 57),
(79, 67, 'Tenho-me sentido com medo, ou muito assustada, sem grande motivo', '0', 2, 363, 57),
(80, 68, 'Tenho sentido que são coisas demais para mim', '2', 2, 706, 57),
(81, 69, 'Tenho-me sentido tão infeliz que durmo mal', '0', 2, 187, 57),
(82, 70, 'Tenho-me sentido triste ou muito infeliz', '2', 2, 977, 57),
(83, 71, 'Tenho-me sentido tão infeliz que choro', '1', 2, 256, 57),
(84, 72, 'Tive ideias de fazer mal a mim mesma', '0', 2, 487, 57);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `evaluates`
--
ALTER TABLE `evaluates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `evaluates`
--
ALTER TABLE `evaluates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
