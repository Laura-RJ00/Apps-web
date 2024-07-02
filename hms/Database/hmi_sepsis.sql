-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 17, 2023 at 01:44 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hmi_sepsis`
--

-- --------------------------------------------------------

--
-- Table structure for table `antibioticos_usados`
--

CREATE TABLE `antibioticos_usados` (
  `index_prescrito` int NOT NULL,
  `pat_id` varchar(45) NOT NULL,
  `ant_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `antibioticos_usados`
--

INSERT INTO `antibioticos_usados` (`index_prescrito`, `pat_id`, `ant_id`) VALUES
(54, '6VIRL', 8),
(55, '6VIRL', 25),
(60, 'HFB60', 8),
(61, 'HFB60', 18),
(64, 'GLO06', 2),
(65, 'GLO06', 57),
(68, 'K6RZV', 8),
(69, 'K6RZV', 18);

-- --------------------------------------------------------

--
-- Table structure for table `caso`
--

CREATE TABLE `caso` (
  `case_pat_id` varchar(45) NOT NULL,
  `pat_diag_ingreso` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cl_find_id` int DEFAULT NULL,
  `foco_infecc` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `tipologia_pat` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `agent_etio` int DEFAULT NULL,
  `VM_96h` int DEFAULT NULL,
  `traqueo` int DEFAULT NULL,
  `infecccion_nosoco` int DEFAULT NULL,
  `upp` int DEFAULT NULL,
  `fmo` int DEFAULT NULL,
  `perdida_masa_musc` int DEFAULT NULL,
  `malnutricion` int DEFAULT NULL,
  `det_cognitivo` int DEFAULT NULL,
  `status_ecc` int DEFAULT NULL,
  `pcr_pics` int DEFAULT NULL,
  `linfo_pics` int DEFAULT NULL,
  `albumnina_pics` int DEFAULT NULL,
  `rbp_pics` int DEFAULT NULL,
  `prealbumina_pics` int DEFAULT NULL,
  `status_pics` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `caso`
--

INSERT INTO `caso` (`case_pat_id`, `pat_diag_ingreso`, `cl_find_id`, `foco_infecc`, `tipologia_pat`, `agent_etio`, `VM_96h`, `traqueo`, `infecccion_nosoco`, `upp`, `fmo`, `perdida_masa_musc`, `malnutricion`, `det_cognitivo`, `status_ecc`, `pcr_pics`, `linfo_pics`, `albumnina_pics`, `rbp_pics`, `prealbumina_pics`, `status_pics`) VALUES
('6VIRL', 'Shock séptico', 10001005, 'Respiratorio', 'Comunitaria', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('GLO06', 'Shock séptico', 10001005, 'Urinario', 'Comunitaria', 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('HFB60', 'Shock séptico', 10001005, 'Respiratorio', 'Comunitaria', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 1),
('K6RZV', 'Sepsis', 91302008, 'Respiratorio', 'Comunitaria', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clinical_finding`
--

CREATE TABLE `clinical_finding` (
  `cl_find_id` int NOT NULL,
  `cl_find_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `clinical_finding`
--

INSERT INTO `clinical_finding` (`cl_find_id`, `cl_find_name`) VALUES
(2858002, 'Sepsis puerperal'),
(10001005, 'Sepsis bacteriana'),
(91302008, 'Sepsis'),
(276678006, 'Sepsis umbilical '),
(700054008, 'Sepsis causada por hongo '),
(707271004, 'Sepsis debido a infección oral'),
(713854001, 'Sepsis perinatal'),
(721104000, 'Sepsis debido a infección del tracto urinario'),
(770349000, 'Sepsis causada por virus ');

-- --------------------------------------------------------

--
-- Table structure for table `codigo_sexo`
--

CREATE TABLE `codigo_sexo` (
  `sex_codes` int NOT NULL,
  `pat_sex_name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `codigo_sexo`
--

INSERT INTO `codigo_sexo` (`sex_codes`, `pat_sex_name`) VALUES
(0, 'HOMBRE'),
(1, 'MUJER');

-- --------------------------------------------------------

--
-- Table structure for table `control`
--

CREATE TABLE `control` (
  `control_pat_id` varchar(45) NOT NULL,
  `control_type` varchar(90) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `control`
--

INSERT INTO `control` (`control_pat_id`, `control_type`) VALUES
('UQRPL', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `diseases`
--

CREATE TABLE `diseases` (
  `dis_id` int NOT NULL,
  `dis_tipologia` varchar(45) NOT NULL,
  `dis_foco_infecc` varchar(45) NOT NULL,
  `dis_agent_etiologico` varchar(45) NOT NULL,
  `dis_index` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `historial_descargas`
--

CREATE TABLE `historial_descargas` (
  `index_descarga` int NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `fecha_descarga` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_docs`
--

CREATE TABLE `hospital_docs` (
  `hosp_id` int NOT NULL,
  `hosp_name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `hosp_location` varchar(90) NOT NULL,
  `hosp_resp_name` varchar(45) NOT NULL,
  `hosp_resp_mail` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `hospital_docs`
--

INSERT INTO `hospital_docs` (`hosp_id`, `hosp_name`, `hosp_location`, `hosp_resp_name`, `hosp_resp_mail`) VALUES
(1, 'Hospital Clinico', 'Valencia', 'Edurne', 'edurne@mail'),
(2, 'Hospital Vall d\'Hebron', 'Barcelona', 'doc', 'doc@mail');

-- --------------------------------------------------------

--
-- Table structure for table `lista_micros`
--

CREATE TABLE `lista_micros` (
  `microor_id` int NOT NULL,
  `microor_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tipo_microor` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `lista_micros`
--

INSERT INTO `lista_micros` (`microor_id`, `microor_name`, `tipo_microor`) VALUES
(1, 'Staphylococcus aureus ', 'Gram-positive cocci'),
(2, 'Staphylococcus epidermidis ', 'Gram-positive cocci'),
(3, 'Staphylococcus haemolyticus ', 'Gram-positive cocci'),
(4, 'Coagulase-negative staphylococci, not specified', 'Gram-positive cocci'),
(5, 'Other coagulase-negative staphylococci (CNS)', 'Gram-positive cocci'),
(6, 'Staphylococcus spp., not specified', 'Gram-positive cocci'),
(7, 'Streptococcus pneumoniae ', 'Gram-positive cocci'),
(8, 'Streptococcus agalactiae ', 'Gram-positive cocci'),
(9, 'Streptococcus pyogenes ', 'Gram-positive cocci'),
(10, 'Other haemol. streptococcae (C, G)', 'Gram-positive cocci'),
(11, 'Streptococcus spp., other', 'Gram-positive cocci'),
(12, 'Streptococcus spp., not specified', 'Gram-positive cocci'),
(13, 'Enterococcus faecalis ', 'Gram-positive cocci'),
(14, 'Enterococcus faecium ', 'Gram-positive cocci'),
(15, 'Enterococcus spp., other', 'Gram-positive cocci'),
(16, 'Enterococcus spp., not specified', 'Gram-positive cocci'),
(17, 'Gram-positive cocci, not specified', 'Gram-positive cocci'),
(18, 'Other gram-positive cocci', 'Gram-positive cocci'),
(19, 'Moraxella catharralis ', 'Gram-negative cocci'),
(20, 'Moraxella spp., other', 'Gram-negative cocci'),
(21, 'Moraxella spp., not specified', 'Gram-negative cocci'),
(22, 'Neisseria meningitidis ', 'Gram-negative cocci'),
(23, 'Neisseria spp., other', 'Gram-negative cocci'),
(24, 'Neisseria spp., not specified', 'Gram-negative cocci'),
(25, 'Gram-negative cocci, not specified', 'Gram-negative cocci'),
(26, 'Other gram-negative cocci', 'Gram-negative cocci'),
(27, 'Corynebacterium spp.', 'Gram-positive bacilli'),
(28, 'Bacillus spp.', 'Gram-positive bacilli'),
(29, 'Lactobacillus spp.', 'Gram-positive bacilli'),
(30, 'Listeria monocytogenes ', 'Gram-positive bacilli'),
(31, 'Gram-positive bacilli, not specified', 'Gram-positive bacilli'),
(32, 'Other gram-positive bacilli', 'Gram-positive bacilli'),
(33, 'Citrobacter freundii ', 'Enterobacteriaceae'),
(34, 'Citrobacter koseri ', 'Enterobacteriaceae'),
(35, 'Citrobacter spp., other', 'Enterobacteriaceae'),
(36, 'Citrobacter spp., not specified', 'Enterobacteriaceae'),
(37, 'Enterobacter cloacae ', 'Enterobacteriaceae'),
(38, 'Enterobacter aerogenes ', 'Enterobacteriaceae'),
(39, 'Enterobacter agglomerans ', 'Enterobacteriaceae'),
(40, 'Enterobacter sakazakii ', 'Enterobacteriaceae'),
(41, 'Enterobacter spp., other', 'Enterobacteriaceae'),
(42, 'Enterobacter spp., not specified', 'Enterobacteriaceae'),
(43, 'Escherichia coli ', 'Enterobacteriaceae'),
(44, 'Klebsiella pneumoniae ', 'Enterobacteriaceae'),
(45, 'Klebsiella oxytoca ', 'Enterobacteriaceae'),
(46, 'Klebsiella spp., other', 'Enterobacteriaceae'),
(47, 'Klebsiella spp., not specified', 'Enterobacteriaceae'),
(48, 'Proteus mirabilis ', 'Enterobacteriaceae'),
(49, 'Proteus vulgaris ', 'Enterobacteriaceae'),
(50, 'Proteus spp., other', 'Enterobacteriaceae'),
(51, 'Proteus spp., not specified', 'Enterobacteriaceae'),
(52, 'Serratia marcescens ', 'Enterobacteriaceae'),
(53, 'Serratia liquefaciens ', 'Enterobacteriaceae'),
(54, 'Serratia spp., other', 'Enterobacteriaceae'),
(55, 'Serratia spp., not specified', 'Enterobacteriaceae'),
(56, 'Hafnia spp.', 'Enterobacteriaceae'),
(57, 'Morganella spp.', 'Enterobacteriaceae'),
(58, 'Providencia spp.', 'Enterobacteriaceae'),
(59, 'Salmonella spp., not specified', 'Enterobacteriaceae'),
(60, 'Shigella spp.', 'Enterobacteriaceae'),
(61, 'Yersinia spp.', 'Enterobacteriaceae'),
(62, 'Other Enterobacteriaceae', 'Enterobacteriaceae'),
(63, 'Enterobacteriaceae, not specified', 'Enterobacteriaceae'),
(64, 'Acinetobacter baumannii ', 'Gram-neg., non-enterobacteriaceae'),
(65, 'Acinetobacter calcoaceticus ', 'Gram-neg., non-enterobacteriaceae'),
(66, 'Acinetobacter haemolyticus ', 'Gram-neg., non-enterobacteriaceae'),
(67, 'Acinetobacter lwoffii ', 'Gram-neg., non-enterobacteriaceae'),
(68, 'Acinetobacter spp., other', 'Gram-neg., non-enterobacteriaceae'),
(69, 'Acinetobacter spp., not specified', 'Gram-neg., non-enterobacteriaceae'),
(70, 'Pseudomonas aeruginosa ', 'Gram-neg., non-enterobacteriaceae'),
(71, 'Stenotrophomonas maltophilia ', 'Gram-neg., non-enterobacteriaceae'),
(72, 'Burkholderia cepacia ', 'Gram-neg., non-enterobacteriaceae'),
(73, 'Pseudomonadaceae family, other', 'Gram-neg., non-enterobacteriaceae'),
(74, 'Pseudomonadaceae family, not specified', 'Gram-neg., non-enterobacteriaceae'),
(75, 'Haemophilus influenzae ', 'Gram-neg., non-enterobacteriaceae'),
(76, 'Haemophilus parainfluenzae ', 'Gram-neg., non-enterobacteriaceae'),
(77, 'Haemophilus spp., other', 'Gram-neg., non-enterobacteriaceae'),
(78, 'Haemophilus spp., not specified', 'Gram-neg., non-enterobacteriaceae'),
(79, 'Legionella spp.', 'Gram-neg., non-enterobacteriaceae'),
(80, 'Achromobacter spp.', 'Gram-neg., non-enterobacteriaceae'),
(81, 'Aeromonas spp.', 'Gram-neg., non-enterobacteriaceae'),
(82, 'Alcaligenes spp.', 'Gram-neg., non-enterobacteriaceae'),
(83, 'Campylobacter spp.', 'Gram-neg., non-enterobacteriaceae'),
(84, 'Flavobacterium spp.', 'Gram-neg., non-enterobacteriaceae'),
(85, 'Helicobacter pylori ', 'Gram-neg., non-enterobacteriaceae'),
(86, 'Pasteurella spp.', 'Gram-neg., non-enterobacteriaceae'),
(87, 'Gram-neg bacilli, not specified', 'Gram-neg., non-enterobacteriaceae'),
(88, 'Other gram-neg Bacilli, non Enterobacteriaceae', 'Gram-neg., non-enterobacteriaceae'),
(89, 'Bacteroides fragilis ', 'Anaerobic bacilli'),
(90, 'Bacteroides spp., other', 'Anaerobic bacilli'),
(91, 'Bacteroides spp., not specified', 'Anaerobic bacilli'),
(92, 'Clostridium difficile ', 'Anaerobic bacilli'),
(93, 'Clostridium spp., other', 'Anaerobic bacilli'),
(94, 'Propionibacterium spp.', 'Anaerobic bacilli'),
(95, 'Prevotella spp.', 'Anaerobic bacilli'),
(96, 'Anaerobes, not specified', 'Anaerobic bacilli'),
(97, 'Other anaerobes', 'Anaerobic bacilli'),
(98, 'Mycobacterium, atypical ', 'Other bacteria'),
(99, 'Mycoplasma spp.', 'Other bacteria'),
(100, 'Actinomyces spp.', 'Other bacteria'),
(101, 'Nocardia spp.', 'Other bacteria'),
(102, 'Other bacteria', 'Other bacteria'),
(103, 'Other bacteria, not specified', 'Other bacteria'),
(104, 'Fungi', ''),
(105, 'Candida albicans ', 'Fungi'),
(106, 'Candida glabrata ', 'Fungi'),
(107, 'Candida krusei ', 'Fungi'),
(108, 'Candida parapsilosis ', 'Fungi'),
(109, 'Candida tropicalis ', 'Fungi'),
(110, 'Candida spp., other', 'Fungi'),
(111, 'Candida spp., not specified', 'Fungi'),
(112, 'Aspergillus fumigatus ', 'Fungi'),
(113, 'Aspergillus niger ', 'Fungi'),
(114, 'Aspergillus spp., other', 'Fungi'),
(115, 'Aspergillus spp., not specified', 'Fungi'),
(116, 'Other yeasts', 'Fungi'),
(117, 'Fungi other', 'Fungi'),
(118, 'Filaments other', 'Fungi'),
(119, 'Other parasites', 'Fungi'),
(120, 'Adenovirus', 'Virus'),
(121, 'Cytomegalovirus (CMV)', 'Virus'),
(122, 'Hepatitis C virus', 'Virus'),
(123, 'Herpes simplex virus', 'Virus'),
(124, 'Human immunodeficiency virus (HIV)', 'Virus'),
(125, 'Norovirus', 'Virus'),
(126, 'Parainfluenzavirus', 'Virus'),
(127, 'Respiratory syncytial virus (RSV)', 'Virus'),
(128, 'Rotavirus', 'Virus'),
(129, 'Varicella-zoster virus', 'Virus'),
(130, 'Virus, not specified', 'Virus'),
(131, 'Other virus', 'Virus'),
(9999998, 'Negativo', 'No aplica'),
(9999999, 'No filiado', 'No aplica'),
(10000042, 'No aplica', 'No aplica');

-- --------------------------------------------------------

--
-- Table structure for table `lista_vars`
--

CREATE TABLE `lista_vars` (
  `index_var` int NOT NULL,
  `nombre_var` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `list_antibioticos`
--

CREATE TABLE `list_antibioticos` (
  `ant_id` int NOT NULL,
  `nombre_ant` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `list_antibioticos`
--

INSERT INTO `list_antibioticos` (`ant_id`, `nombre_ant`) VALUES
(1, 'Aciclovir'),
(2, 'Amikacina'),
(3, 'Amoxicilina'),
(5, 'Ampicilina'),
(6, 'Anfotericina B'),
(7, 'Anidulafungina'),
(8, 'Azitromicina'),
(9, 'Aztreonam'),
(10, 'Caspofungina'),
(11, 'Cefalotina'),
(12, 'Cefamandol'),
(13, 'Cefazolina'),
(14, 'Cefepime'),
(15, 'Cefiderocol'),
(16, 'Cefotaxima'),
(17, 'Cefoxitina'),
(18, 'Ceftarolina'),
(19, 'Ceftarolina-Avibactam'),
(20, 'Ceftarolina-fosamil'),
(21, 'Ceftazidima'),
(22, 'Ceftazidima-avibactam'),
(23, 'Ceftizoxima'),
(24, 'Ceftolozano-tazobactam'),
(25, 'Ceftriaxona'),
(26, 'Cefuroxima'),
(27, 'Ciprofloxacino'),
(28, 'Claritromicina'),
(29, 'Clindamicina'),
(30, 'Clotrimazol'),
(31, 'Cloxacilina'),
(32, 'Colimicina'),
(33, 'Cotrimoxazol (Trimetroprim-Sulfametoxazol)'),
(34, 'Daptomicina'),
(35, 'Dalbavancina'),
(36, 'ddC'),
(37, 'DDS'),
(38, 'Delafloxacino'),
(39, 'Doxiciclina'),
(40, 'Entavicina'),
(41, 'Eritromicina'),
(42, 'Ertapenem'),
(43, 'Etambutol'),
(44, 'Fidaxomicina'),
(45, 'Fluconazol'),
(46, 'Foscarnet'),
(47, 'Fosfomicina'),
(48, 'Ganciclovir'),
(49, 'Gentamicina'),
(50, 'Imipenem '),
(51, 'Imipenem-Cilastatina'),
(52, 'Isavuconazol'),
(53, 'Isoniacida'),
(54, 'Itraconazol'),
(55, 'Levofloxacino'),
(56, 'Linezolid'),
(57, 'Meropenem'),
(58, 'Meropenem-vaborbactam'),
(59, 'Meropenem-relebactam'),
(60, 'Metronidazol'),
(61, 'Micafungina'),
(62, 'Moxifloxacino'),
(63, 'Mupirocina'),
(64, 'Nistatina'),
(65, 'Norfloxacino'),
(66, 'Oritovancina'),
(67, 'Oseltamivir'),
(68, 'Plazomicina'),
(69, 'Penicilina G'),
(70, 'Piperacilina-Tazobactam'),
(71, 'Pirazinamida'),
(72, 'Posaconazol'),
(73, 'Remdesivir'),
(74, 'Rifampicina'),
(75, 'Rifaximina'),
(76, 'Tedizolid'),
(77, 'Teicoplanina'),
(78, 'Tigeciclina'),
(79, 'Tobramicina'),
(80, 'Valaciclovir'),
(81, 'Valganciclovir'),
(82, 'Vancomicina'),
(83, 'Voriconazol');

-- --------------------------------------------------------

--
-- Table structure for table `list_marcadores`
--

CREATE TABLE `list_marcadores` (
  `marcador_index` int NOT NULL,
  `codigo_var` int NOT NULL,
  `tipo_marcador` varchar(45) NOT NULL,
  `hallazgo_asociado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `manejo_inicial`
--

CREATE TABLE `manejo_inicial` (
  `pat_id` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `apache_2` int DEFAULT NULL,
  `bacteriemia` int DEFAULT NULL,
  `lactato_6h` float DEFAULT NULL,
  `lactato_elimina` int DEFAULT NULL,
  `coloides` float DEFAULT NULL,
  `cristaloides` float DEFAULT NULL,
  `ecocardio_frac` float DEFAULT NULL,
  `sat_ven_central` float DEFAULT NULL,
  `ecocardio_ven_cava_inf` float DEFAULT NULL,
  `desescalada_72_antibio` int DEFAULT NULL,
  `comentarios_micros` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `manejo_inicial`
--

INSERT INTO `manejo_inicial` (`pat_id`, `apache_2`, `bacteriemia`, `lactato_6h`, `lactato_elimina`, `coloides`, `cristaloides`, `ecocardio_frac`, `sat_ven_central`, `ecocardio_ven_cava_inf`, `desescalada_72_antibio`, `comentarios_micros`) VALUES
('6VIRL', 13, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 'EXUDADO NASOFARÍNGEO: COVID-19 E INFLUENZA A Y B NEGATIVOS'),
('GLO06', 14, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, 'COPROCULTIVO: NEGATIVO'),
('HFB60', 19, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 'VIRUS RESPIRTARIOS:NEGATIVOS'),
('K6RZV', 6, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 'VIRUS RESPIRATORIOS: NEGATIVOS'),
('UQRPL', 8, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `microorganismos`
--

CREATE TABLE `microorganismos` (
  `index_test` int NOT NULL,
  `case_pat_id` varchar(45) NOT NULL,
  `microorg_id` int DEFAULT NULL,
  `test_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `microorganismos`
--

INSERT INTO `microorganismos` (`index_test`, `case_pat_id`, `microorg_id`, `test_id`) VALUES
(1080, '6VIRL', 9999998, 1),
(1081, '6VIRL', 9999998, 5),
(1082, '6VIRL', 7, 6),
(1083, '6VIRL', NULL, 4),
(1084, '6VIRL', NULL, 2),
(1085, '6VIRL', NULL, 3),
(1086, '6VIRL', NULL, 7),
(1087, '6VIRL', NULL, 8),
(1112, 'HFB60', 7, 1),
(1113, 'HFB60', 7, 5),
(1114, 'HFB60', 7, 6),
(1115, 'HFB60', NULL, 4),
(1116, 'HFB60', NULL, 2),
(1117, 'HFB60', NULL, 3),
(1118, 'HFB60', NULL, 7),
(1119, 'HFB60', NULL, 8),
(1128, 'GLO06', 9999998, 1),
(1129, 'GLO06', NULL, 5),
(1130, 'GLO06', 9999998, 6),
(1131, 'GLO06', NULL, 4),
(1132, 'GLO06', NULL, 2),
(1133, 'GLO06', NULL, 3),
(1134, 'GLO06', 43, 7),
(1135, 'GLO06', NULL, 8),
(1144, 'K6RZV', 9999998, 1),
(1145, 'K6RZV', 9999998, 5),
(1146, 'K6RZV', 9999998, 6),
(1147, 'K6RZV', NULL, 4),
(1148, 'K6RZV', NULL, 2),
(1149, 'K6RZV', NULL, 3),
(1150, 'K6RZV', NULL, 7),
(1151, 'K6RZV', NULL, 8);

-- --------------------------------------------------------

--
-- Table structure for table `micro_tests`
--

CREATE TABLE `micro_tests` (
  `test_index` int NOT NULL,
  `test_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `micro_tests`
--

INSERT INTO `micro_tests` (`test_index`, `test_name`) VALUES
(1, 'Hemocultivos'),
(2, 'Catéter'),
(3, 'LCR'),
(4, 'Abdomen'),
(5, 'Aspirado traqueal'),
(6, 'Ag urinarios'),
(7, 'Urinocultivos'),
(8, 'Otros');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `pat_index` int NOT NULL,
  `pat_id` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `pat_doc_assigned` varchar(45) NOT NULL,
  `pat_record_status` int DEFAULT NULL,
  `pat_sip` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `pat_nhc` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `pat_age` int DEFAULT NULL,
  `pat_dateBirth` date DEFAULT NULL,
  `pat_sex` int DEFAULT NULL,
  `pat_weight` float DEFAULT NULL,
  `pat_height` float DEFAULT NULL,
  `pat_imc` float DEFAULT NULL,
  `pàt_data_joined` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `pat_role` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `pat_date_ingreso` date DEFAULT NULL,
  `pat_date_alta` date DEFAULT NULL,
  `pat_date_ingreso_uci` date DEFAULT NULL,
  `pat_date_alta_uci` date DEFAULT NULL,
  `estancia_hosp` int DEFAULT NULL,
  `exitus` int DEFAULT NULL,
  `asv` int DEFAULT NULL,
  `intrauci` int DEFAULT NULL,
  `exitus_28d` int DEFAULT NULL,
  `date_exitus` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`pat_index`, `pat_id`, `pat_doc_assigned`, `pat_record_status`, `pat_sip`, `pat_nhc`, `pat_age`, `pat_dateBirth`, `pat_sex`, `pat_weight`, `pat_height`, `pat_imc`, `pàt_data_joined`, `pat_role`, `pat_date_ingreso`, `pat_date_alta`, `pat_date_ingreso_uci`, `pat_date_alta_uci`, `estancia_hosp`, `exitus`, `asv`, `intrauci`, `exitus_28d`, `date_exitus`) VALUES
(1, '6VIRL', '0JRHO', 0, '2538252', '296369', 72, '1951-02-17', 0, 80, 1.7, 27.68, '2023-06-30 22:00:00.000000', 'Caso', '2023-04-11', '2023-04-14', '2023-04-11', '2023-04-13', 2, 0, 0, 0, 0, NULL),
(2, 'GLO06', '0JRHO', 0, '12998283', '876371', 47, '1975-06-28', 1, 74.5, 1.6, 29.1, '2023-07-05 22:00:00.000000', 'Caso', '2023-03-30', '2023-04-08', '2023-03-30', '2023-04-02', 3, 0, 0, 0, 0, NULL),
(3, 'HFB60', '0JRHO', 1, '13725611', '902763', 34, '1988-11-17', 0, 64, 1.67, 22.95, '2023-06-30 22:00:00.000000', 'Caso', '2023-04-26', '2023-05-23', '2023-04-26', '2023-05-23', 27, 1, 0, 1, 0, '2023-05-23'),
(4, 'K6RZV', '0JRHO', NULL, '2662776', '841561', 35, '1988-03-31', 1, 159, 1.53, 67.92, '2023-07-05 22:00:00.000000', 'Caso', '2023-04-03', '2023-04-13', '2023-04-03', '2023-04-11', 8, 0, 0, 0, 0, NULL),
(5, 'UQRPL', '0JRHO', 1, '7495115', '882151', 73, NULL, 0, 68, 1.75, 22.2, '2023-06-30 22:00:00.000000', 'Control', '2022-09-07', '2022-09-19', '2022-09-07', '2022-09-10', 3, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pat_risk_factors`
--

CREATE TABLE `pat_risk_factors` (
  `pat_id` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `infarto_miocardio` int DEFAULT NULL,
  `insuficiencia_cardiac_congest` int DEFAULT NULL,
  `enf_vasc_periferica` int DEFAULT NULL,
  `enf_cerebro_vasc` int DEFAULT NULL,
  `demencial` int DEFAULT NULL,
  `epoc` int DEFAULT NULL,
  `patologia_conect` int DEFAULT NULL,
  `patologia_hepa_leve` int DEFAULT NULL,
  `patologia_hepa_grav_mod` int DEFAULT NULL,
  `ulcera` int DEFAULT NULL,
  `diabetes` int DEFAULT NULL,
  `diabetes_lesion_org` int DEFAULT NULL,
  `hemiplejia` int DEFAULT NULL,
  `patologia_renal_grav_mod` int DEFAULT NULL,
  `tumor_solido` int DEFAULT NULL,
  `metastasis` int DEFAULT NULL,
  `leucemia` int DEFAULT NULL,
  `linfomas` int DEFAULT NULL,
  `sida` int DEFAULT NULL,
  `charlson` int NOT NULL,
  `hta` int DEFAULT NULL,
  `tabaco` int DEFAULT NULL,
  `alcohol` int DEFAULT NULL,
  `cardio_isquemia_cronica` int DEFAULT NULL,
  `dislipemia` int DEFAULT NULL,
  `enf_hemato_maligna` int DEFAULT NULL,
  `corticoides` int DEFAULT NULL,
  `inmunosupr` int DEFAULT NULL,
  `atb_prev_ingreso` int DEFAULT NULL,
  `ingreso_prev` int DEFAULT NULL,
  `ult_ingreso_num` int DEFAULT NULL,
  `ult_ingreso` varchar(45) DEFAULT NULL,
  `CFS` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `pat_risk_factors`
--

INSERT INTO `pat_risk_factors` (`pat_id`, `infarto_miocardio`, `insuficiencia_cardiac_congest`, `enf_vasc_periferica`, `enf_cerebro_vasc`, `demencial`, `epoc`, `patologia_conect`, `patologia_hepa_leve`, `patologia_hepa_grav_mod`, `ulcera`, `diabetes`, `diabetes_lesion_org`, `hemiplejia`, `patologia_renal_grav_mod`, `tumor_solido`, `metastasis`, `leucemia`, `linfomas`, `sida`, `charlson`, `hta`, `tabaco`, `alcohol`, `cardio_isquemia_cronica`, `dislipemia`, `enf_hemato_maligna`, `corticoides`, `inmunosupr`, `atb_prev_ingreso`, `ingreso_prev`, `ult_ingreso_num`, `ult_ingreso`, `CFS`) VALUES
('6VIRL', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 6, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, '0', 3),
('GLO06', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, '0', 2),
('HFB60', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0', 0),
('K6RZV', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0', 3),
('UQRPL', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 1, 0, 0, 1, 1, 0, 0, 1, 0, 0, 0, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `research_centers`
--

CREATE TABLE `research_centers` (
  `center_id` int NOT NULL,
  `center_name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `res_location` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `res_responsable` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `res_center_mail` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `research_centers`
--

INSERT INTO `research_centers` (`center_id`, `center_name`, `res_location`, `res_responsable`, `res_center_mail`) VALUES
(1, 'Epidisease', 'Valencia', 'Jose Luis', 'joseluis@mail');

-- --------------------------------------------------------

--
-- Table structure for table `reset_pwd_usuarios`
--

CREATE TABLE `reset_pwd_usuarios` (
  `id_reset` int NOT NULL,
  `fecha_solicitud` datetime DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(45) NOT NULL,
  `token` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `pwd` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `tto_terapia`
--

CREATE TABLE `tto_terapia` (
  `index_tto` int NOT NULL,
  `pat_id` varchar(45) NOT NULL,
  `id_dia` int DEFAULT NULL,
  `DVA` int DEFAULT NULL,
  `DVA_dias` int DEFAULT NULL,
  `TRRC` int DEFAULT NULL,
  `TRRC_dias` int DEFAULT NULL,
  `VM` int DEFAULT NULL,
  `VM_dias` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tto_terapia`
--

INSERT INTO `tto_terapia` (`index_tto`, `pat_id`, `id_dia`, `DVA`, `DVA_dias`, `TRRC`, `TRRC_dias`, `VM`, `VM_dias`) VALUES
(61, '6VIRL', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'GLO06', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'HFB60', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'K6RZV', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'UQRPL', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `logId` int NOT NULL,
  `logOutTime` datetime DEFAULT NULL,
  `loginTime` datetime(6) NOT NULL,
  `user_id` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`logId`, `logOutTime`, `loginTime`, `user_id`) VALUES
(54129, NULL, '2023-07-10 00:00:00.000000', '0JRHO'),
(230869, '2023-07-06 00:00:00', '2023-07-06 00:00:00.000000', '0JRHO'),
(260547, '2023-06-30 00:00:00', '2023-06-30 00:00:00.000000', '0JRHO'),
(267913, NULL, '2023-07-02 00:00:00.000000', '0JRHO'),
(384291, NULL, '2023-06-30 00:00:00.000000', '0JRHO'),
(432678, '2023-06-29 00:00:00', '2023-06-28 00:00:00.000000', '0JRHO'),
(526814, '2023-07-06 00:00:00', '2023-07-06 00:00:00.000000', '0JRHO'),
(529417, NULL, '2023-07-01 00:00:00.000000', 'YDS7L'),
(543681, NULL, '2023-06-27 00:00:00.000000', '0JRHO'),
(564237, NULL, '2023-07-10 00:00:00.000000', '0JRHO'),
(568493, '2023-06-26 00:00:00', '2023-06-26 00:00:00.000000', '0JRHO'),
(604715, '2023-06-26 00:00:00', '2023-06-26 00:00:00.000000', '0JRHO'),
(693172, NULL, '2023-07-06 00:00:00.000000', '0JRHO'),
(817562, NULL, '2023-06-26 00:00:00.000000', '0JRHO'),
(839254, '2023-06-26 00:00:00', '2023-06-26 00:00:00.000000', '0JRHO'),
(840692, '2023-06-30 00:00:00', '2023-06-29 00:00:00.000000', '0JRHO'),
(873416, '2023-07-01 00:00:00', '2023-07-01 00:00:00.000000', '0JRHO'),
(875931, NULL, '2023-06-28 00:00:00.000000', '0JRHO'),
(879254, '2023-06-26 00:00:00', '2023-06-26 00:00:00.000000', '0JRHO'),
(925046, '2023-07-06 00:00:00', '2023-07-06 00:00:00.000000', '0JRHO'),
(946523, '2023-07-06 00:00:00', '2023-07-06 00:00:00.000000', '0JRHO');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(45) NOT NULL,
  `user_rol` int NOT NULL,
  `user_mail` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_rol`, `user_mail`) VALUES
('SN884', 3, 'admin@mail.com'),
('0JRHO', 2, 'elencliment@gmail.com'),
('X460V', 1, 'joseluis@mail.com'),
('YDS7L', 2, 'luisa@mail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `rol_id` int NOT NULL,
  `rol_description` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`rol_id`, `rol_description`) VALUES
(1, 'Investigador'),
(2, 'Doctor'),
(3, 'Administrador');

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE `user_admin` (
  `admin_id` varchar(45) NOT NULL,
  `admin_name` varchar(45) NOT NULL,
  `admin_mail` varchar(45) NOT NULL,
  `admin_pic` varchar(45) DEFAULT NULL,
  `admin_pwd` varchar(45) NOT NULL,
  `admin_surname` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`admin_id`, `admin_name`, `admin_mail`, `admin_pic`, `admin_pwd`, `admin_surname`) VALUES
('SN884', 'Administrador', 'admin@mail.com', '', '4c7f5919e957f354d57243d37f223cf31e9e7181', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_docs`
--

CREATE TABLE `user_docs` (
  `doc_id` varchar(45) NOT NULL,
  `doc_index` int NOT NULL,
  `doc_name` varchar(45) NOT NULL,
  `doc_surname` varchar(45) NOT NULL,
  `doc_pic` varchar(200) DEFAULT NULL,
  `doc_mail` varchar(45) NOT NULL,
  `doc_pwd` varchar(45) NOT NULL,
  `doc_hospital` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_docs`
--

INSERT INTO `user_docs` (`doc_id`, `doc_index`, `doc_name`, `doc_surname`, `doc_pic`, `doc_mail`, `doc_pwd`, `doc_hospital`) VALUES
('0JRHO', 3, 'Elena', 'Climent Martínez', NULL, 'elencliment@gmail.com', '8c8e45d00d533cc160565c0aafcd6d', 1),
('YDS7L', 1, 'Doctora Luisa', 'López', NULL, 'luisa@mail.com', 'd9e38b0e0302689b4dd2acf6a5d0b5178f466d6b', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_research`
--

CREATE TABLE `user_research` (
  `res_index` int NOT NULL,
  `res_id` varchar(45) NOT NULL,
  `res_name` varchar(45) NOT NULL,
  `res_surname` varchar(45) NOT NULL,
  `res_center` int DEFAULT NULL,
  `res_pic` varchar(45) DEFAULT NULL,
  `res_pwd` varchar(45) NOT NULL,
  `res_mail` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_research`
--

INSERT INTO `user_research` (`res_index`, `res_id`, `res_name`, `res_surname`, `res_center`, `res_pic`, `res_pwd`, `res_mail`) VALUES
(2, 'X460V', 'Jose Luis', 'GARCIA', 1, NULL, '67a623753859692d68e32b96f2d2c0b3846d6cc7', 'joseluis@mail.com');

-- --------------------------------------------------------

--
-- Table structure for table `vars`
--

CREATE TABLE `vars` (
  `id_dia` int NOT NULL,
  `id_tipo_toma` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `pat_id` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status_dia` int DEFAULT NULL,
  `UCI` int NOT NULL,
  `SOFA` varchar(45) DEFAULT NULL,
  `PCR` varchar(45) DEFAULT NULL,
  `lactato` varchar(45) DEFAULT NULL,
  `pH` varchar(45) DEFAULT NULL,
  `procalcitonina` varchar(45) DEFAULT NULL,
  `H2B` varchar(45) DEFAULT NULL,
  `H3` varchar(45) DEFAULT NULL,
  `H4` varchar(45) DEFAULT NULL,
  `PCA` varchar(45) DEFAULT NULL,
  `prot_C` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `il6` varchar(45) DEFAULT NULL,
  `comentarios_histonas` varchar(200) DEFAULT NULL,
  `FR` varchar(45) DEFAULT NULL,
  `TAS` varchar(45) DEFAULT NULL,
  `TAM` varchar(45) DEFAULT NULL,
  `proteina_total` varchar(45) DEFAULT NULL,
  `leucocitos` varchar(45) DEFAULT NULL,
  `hemoglobina` varchar(45) DEFAULT NULL,
  `plaquetas` varchar(45) DEFAULT NULL,
  `neutrofilos` varchar(45) DEFAULT NULL,
  `albumina` varchar(45) DEFAULT NULL,
  `prealbumina` varchar(45) DEFAULT NULL,
  `Ca` varchar(45) DEFAULT NULL,
  `acido_urico` varchar(45) DEFAULT NULL,
  `colesterol_total` varchar(45) DEFAULT NULL,
  `trigliceridos` varchar(45) DEFAULT NULL,
  `hdl` varchar(45) DEFAULT NULL,
  `ldl` varchar(45) DEFAULT NULL,
  `trasaminasa_gpt` varchar(45) DEFAULT NULL,
  `trasaminasa_got` varchar(45) DEFAULT NULL,
  `transaminasa_ggt` varchar(45) DEFAULT NULL,
  `fosfatasa_alcalina` varchar(45) DEFAULT NULL,
  `Fe` varchar(45) DEFAULT NULL,
  `IST` varchar(45) DEFAULT NULL,
  `bilirrubina_total` varchar(45) DEFAULT NULL,
  `bilirrubina_direct` varchar(45) DEFAULT NULL,
  `transferrina` varchar(45) DEFAULT NULL,
  `ferritina` varchar(45) DEFAULT NULL,
  `fosforo` varchar(45) DEFAULT NULL,
  `Zn` varchar(45) DEFAULT NULL,
  `linfocitos_abs` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `linfocitos_cd3_abs` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `linfocitos_cd4_abs` varchar(45) DEFAULT NULL,
  `linfocitos_cd8_abs` varchar(45) DEFAULT NULL,
  `cd4_cd8_abs` varchar(45) DEFAULT NULL,
  `linfocitos_cd3` varchar(45) DEFAULT NULL,
  `linfocitos_cd4` varchar(45) DEFAULT NULL,
  `linfocitos_cd8` varchar(45) DEFAULT NULL,
  `cd4_cd8` varchar(45) DEFAULT NULL,
  `ratio_cd4_cd8` varchar(45) DEFAULT NULL,
  `magnesio` varchar(45) DEFAULT NULL,
  `glucosa` varchar(45) DEFAULT NULL,
  `urea` varchar(45) DEFAULT NULL,
  `creatinina` varchar(45) DEFAULT NULL,
  `Na` varchar(45) DEFAULT NULL,
  `K` varchar(45) DEFAULT NULL,
  `Cl` varchar(45) DEFAULT NULL,
  `Pa02` varchar(45) DEFAULT NULL,
  `Fi02` varchar(45) DEFAULT NULL,
  `Pa02_Fi02` varchar(45) DEFAULT NULL,
  `bicarbonato` varchar(45) DEFAULT NULL,
  `dimero_d` varchar(45) DEFAULT NULL,
  `fibrinogeno` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `t_tromboplastina_parcial_act` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `troponina_cardiac_ultrasensib` varchar(45) DEFAULT NULL,
  `t_pro_trombina` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `LDH` varchar(45) DEFAULT NULL,
  `antitrombina_3` varchar(45) DEFAULT NULL,
  `PaC02` varchar(45) DEFAULT NULL,
  `ind_quick` varchar(45) DEFAULT NULL,
  `nt_proBNP` varchar(45) DEFAULT NULL,
  `rbp` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `hematocrito` varchar(45) DEFAULT NULL,
  `inr` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cpk` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `vars`
--

INSERT INTO `vars` (`id_dia`, `id_tipo_toma`, `pat_id`, `status_dia`, `UCI`, `SOFA`, `PCR`, `lactato`, `pH`, `procalcitonina`, `H2B`, `H3`, `H4`, `PCA`, `prot_C`, `il6`, `comentarios_histonas`, `FR`, `TAS`, `TAM`, `proteina_total`, `leucocitos`, `hemoglobina`, `plaquetas`, `neutrofilos`, `albumina`, `prealbumina`, `Ca`, `acido_urico`, `colesterol_total`, `trigliceridos`, `hdl`, `ldl`, `trasaminasa_gpt`, `trasaminasa_got`, `transaminasa_ggt`, `fosfatasa_alcalina`, `Fe`, `IST`, `bilirrubina_total`, `bilirrubina_direct`, `transferrina`, `ferritina`, `fosforo`, `Zn`, `linfocitos_abs`, `linfocitos_cd3_abs`, `linfocitos_cd4_abs`, `linfocitos_cd8_abs`, `cd4_cd8_abs`, `linfocitos_cd3`, `linfocitos_cd4`, `linfocitos_cd8`, `cd4_cd8`, `ratio_cd4_cd8`, `magnesio`, `glucosa`, `urea`, `creatinina`, `Na`, `K`, `Cl`, `Pa02`, `Fi02`, `Pa02_Fi02`, `bicarbonato`, `dimero_d`, `fibrinogeno`, `t_tromboplastina_parcial_act`, `troponina_cardiac_ultrasensib`, `t_pro_trombina`, `LDH`, `antitrombina_3`, `PaC02`, `ind_quick`, `nt_proBNP`, `rbp`, `hematocrito`, `inr`, `cpk`) VALUES
(1, 'estudio', '6VIRL', 1, 1, '2', '284.4', '', '7.39', '13.82', '', '', '', '', '51', NULL, NULL, '', '', '', '', '16.84', '13.3', '195', '86.7', '3.5', '16', '7.9', '', '70', '115', '', '', '13', '11', '', '', '9', '', '0.7', '', '', '159', '2.7', '11', '1.46', '47.36', '26.41', '19.84', '0.77', '0.691', '0.386', '0.29', '0.011', '1.33', '1.8', '159', '38', '0.87', '136', '4.4', '109', '77.8', '35', '222', '22.8', '1107', '', '1.01', '4.9', '13.4', '', '69', '33.4', '78', '2730', '', '41', '1.18', ''),
(1, 'estudio', 'GLO06', 1, 1, '9', '631.7', '', '7.4', '', '', '', '', '', '57', NULL, NULL, '', '', '', '', '25.16', '11.3', '197', '93.4', '3.8', '10', '7.7', '', '130', '259', '', '', '63', '71', '', '', '9', '', '0.7', '', '', '2496', '3.4', '21', '0.48', '99.55', '32.83', '61.8', '0.1', '0.478', '0.158', '0.297', '0.001', '0.53', '2.4', '178', '89', '2.33', '145', '5.1', '114', '75.7', '31', '244', '22', '6333', '12.84', '32.5', '25.6', '13.4', '', '68', '29.7', '78', '2466', '', '34', '1.18', ''),
(1, 'estudio', 'HFB60', 1, 1, '7', '302.6', '', '7.31', '71.45', '', '', '', '', '41', NULL, NULL, '', '', '', '', '4.71', '12.2', '157', '84.1', '3', '8', '7.8', '', '112', '350', '', '', '146', '448', '', '', '12', '', '0.5', '', '', '2328', '5.1', '31', '0.4', '0.163', '0.128', '0.035', '0.002', '40.74', '32.07', '8.71', '0.42', '3.68', '2.2', '129', '72', '1.68', '134', '3.5', '101', '120', '100', '120', '22.7', '5787', '11.19', '35.5', '8377', '14.3', '', '36', '39.4', '71', '17361', '', '37', '1.2', ''),
(1, 'estudio', 'K6RZV', 1, 1, '3', '582.2', '', '7.39', '0.41', '', '', '', '', '95', NULL, NULL, '', '-1', '', '', '10.7', '13', '253', '91.1', '3.3', '5', '8.5', '', '130', '104', '', '', '19', '35', '', '', '16', '', '0.3', '', '', '901', '3.5', '51', '0.7', '53.2', '35.99', '15.93', '0.51', '0.372', '0.252', '0.111', '0.004', '2.26', '2.4', '112', '22', '0.61', '133', '4.6', '100', '108', '60', '180', '27.4', '6602', '12.19', '27.9', '17', '1.19', '', '76', '49.2', '77', '161', '', '43', '1.19', ''),
(1, 'estudio', 'UQRPL', 1, 1, '0', '39', '', '7.38', '0.07', '', '', '', '', '101', NULL, NULL, '', '', '', '132', '15850', '15.9', '262', '84.7', '3.3', '19', '8.3', '', '124', '97', '', '', '11', '13', '', '', '63', '', '0.78', '', '', '126', '3.9', '71', '', '0.472', '0.292', '0.178', '0.005', '45.35', '28.07', '17.11', '0.52', '1.64', '2.4', '102', '54', '0.82', '137', '2.9', '102', '', '', '251', '24', '1005', '', '27.5', '21', '13.2', '', '115', '43', '80', '1563', '', '45', '1.17', ''),
(7, 'estudio', 'HFB60', 1, 1, '14', '71', '', '', '', '', '', '', '', '', NULL, NULL, '', '', '', '4.5', '15.47', '7.9', '107', '87.1', '2.6', '9', '8.3', '', '', '', '', '', '', '', '208', '205', '27', '27.3', '3.04', '', '78', '2445', '3.5', '72', '10.3', '1.093', '0.75', '0.356', '0.018', '68.76', '47.15', '22.4', '1.14', '2.11', '2.1', '', '131', '2.15', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '3.5', '24', '', '27451'),
(7, 'estudio', 'K6RZV', 1, 0, '1', '81.4', '', '', '', '', '', '', '', '', NULL, NULL, '', '', '', '7.8', '11.05', '14.1', '441', '68.4', '4.4', '', '9.4', '', '190', '407', '33', '77', '', '', '78', '56', '183', '50.2', '', '', '287', '1443', '9.08', '109', '2.31', '53.2', '46.53', '43.64', '0.5', '2.141', '1.075', '1.008', '0.012', '1.07', '2.2', '', '75', '0.96', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '13.9', '46', '', '442'),
(14, 'estudio', 'HFB60', 1, 1, '10', '119.1', '', '', '', '', '', '', '', '', NULL, NULL, '', '', '', '5.5', '13.85', '8.6', '102', '89.9', '2.5', '13', '8.2', '', '71', '261', '13', '22', '', '', '162', '191', '84', '71.9', '2.33', '', '92', '1191', '3.1', '73', '1.08', '0.816', '0.614', '0.204', '0.007', '75.55', '56.84', '18.8', '0.65', '3.01', '2.3', '', '114', '1.67', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '5.7', '25', '', '1706');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antibioticos_usados`
--
ALTER TABLE `antibioticos_usados`
  ADD PRIMARY KEY (`index_prescrito`),
  ADD KEY `fk_pat` (`pat_id`),
  ADD KEY `fk_ant` (`ant_id`);

--
-- Indexes for table `caso`
--
ALTER TABLE `caso`
  ADD PRIMARY KEY (`case_pat_id`),
  ADD KEY `fk_caso_clinical_finding` (`cl_find_id`),
  ADD KEY `fk_microorg` (`agent_etio`);

--
-- Indexes for table `clinical_finding`
--
ALTER TABLE `clinical_finding`
  ADD PRIMARY KEY (`cl_find_id`),
  ADD UNIQUE KEY `cl_find_id_UNIQUE` (`cl_find_id`);

--
-- Indexes for table `codigo_sexo`
--
ALTER TABLE `codigo_sexo`
  ADD PRIMARY KEY (`sex_codes`),
  ADD UNIQUE KEY `sex_name` (`pat_sex_name`);

--
-- Indexes for table `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`control_pat_id`);

--
-- Indexes for table `diseases`
--
ALTER TABLE `diseases`
  ADD PRIMARY KEY (`dis_index`),
  ADD KEY `id_finding` (`dis_id`);

--
-- Indexes for table `historial_descargas`
--
ALTER TABLE `historial_descargas`
  ADD PRIMARY KEY (`index_descarga`),
  ADD KEY `fk_usuarios` (`usuario`);

--
-- Indexes for table `hospital_docs`
--
ALTER TABLE `hospital_docs`
  ADD PRIMARY KEY (`hosp_name`),
  ADD UNIQUE KEY `hosp_id_UNIQUE` (`hosp_id`),
  ADD UNIQUE KEY `hosp_name_UNIQUE` (`hosp_name`);

--
-- Indexes for table `lista_micros`
--
ALTER TABLE `lista_micros`
  ADD PRIMARY KEY (`microor_id`),
  ADD UNIQUE KEY `microor_name` (`microor_name`);

--
-- Indexes for table `lista_vars`
--
ALTER TABLE `lista_vars`
  ADD PRIMARY KEY (`index_var`),
  ADD UNIQUE KEY `nombre_var` (`nombre_var`);

--
-- Indexes for table `list_antibioticos`
--
ALTER TABLE `list_antibioticos`
  ADD PRIMARY KEY (`ant_id`);

--
-- Indexes for table `list_marcadores`
--
ALTER TABLE `list_marcadores`
  ADD PRIMARY KEY (`marcador_index`),
  ADD UNIQUE KEY `marcador_index` (`marcador_index`),
  ADD KEY `fk_hallazgo` (`hallazgo_asociado`),
  ADD KEY `fk_vars` (`codigo_var`);

--
-- Indexes for table `manejo_inicial`
--
ALTER TABLE `manejo_inicial`
  ADD PRIMARY KEY (`pat_id`),
  ADD UNIQUE KEY `case_pat_id_UNIQUE` (`pat_id`),
  ADD KEY `fk_Manejo_inicial_Caso1_idx` (`pat_id`);

--
-- Indexes for table `microorganismos`
--
ALTER TABLE `microorganismos`
  ADD PRIMARY KEY (`index_test`),
  ADD UNIQUE KEY `microorg_index` (`index_test`),
  ADD KEY `fk_microorganismos_Caso1_idx` (`case_pat_id`),
  ADD KEY `fk_id_agentes_etio` (`microorg_id`),
  ADD KEY `fk_microorganismos_Caso1` (`test_id`);

--
-- Indexes for table `micro_tests`
--
ALTER TABLE `micro_tests`
  ADD PRIMARY KEY (`test_index`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`pat_id`),
  ADD UNIQUE KEY `pat_index` (`pat_index`),
  ADD UNIQUE KEY `pat_sip_UNIQUE` (`pat_sip`),
  ADD UNIQUE KEY `pat_nhc_UNIQUE` (`pat_nhc`),
  ADD KEY `fk_pat_doctor` (`pat_doc_assigned`),
  ADD KEY `fk_sex` (`pat_sex`);

--
-- Indexes for table `pat_risk_factors`
--
ALTER TABLE `pat_risk_factors`
  ADD PRIMARY KEY (`pat_id`);

--
-- Indexes for table `research_centers`
--
ALTER TABLE `research_centers`
  ADD PRIMARY KEY (`center_id`),
  ADD UNIQUE KEY `res_center` (`center_name`);

--
-- Indexes for table `reset_pwd_usuarios`
--
ALTER TABLE `reset_pwd_usuarios`
  ADD PRIMARY KEY (`id_reset`),
  ADD KEY `fk_mail_reset` (`email`);

--
-- Indexes for table `tto_terapia`
--
ALTER TABLE `tto_terapia`
  ADD PRIMARY KEY (`index_tto`),
  ADD KEY `fk_pat_id` (`pat_id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`logId`),
  ADD KEY `fk_UserLog_users1_idx` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`,`user_rol`),
  ADD UNIQUE KEY `idUsuario_UNIQUE` (`user_id`),
  ADD UNIQUE KEY `user_mail` (`user_mail`),
  ADD KEY `fk_users_users_roles1_idx` (`user_rol`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_id_UNIQUE` (`admin_id`);

--
-- Indexes for table `user_docs`
--
ALTER TABLE `user_docs`
  ADD PRIMARY KEY (`doc_id`),
  ADD UNIQUE KEY `doc_number_UNIQUE` (`doc_id`),
  ADD UNIQUE KEY `doc_number` (`doc_index`),
  ADD UNIQUE KEY `doc_mail` (`doc_mail`),
  ADD KEY `fk_user_docs_hospital_docs1_idx` (`doc_hospital`);

--
-- Indexes for table `user_research`
--
ALTER TABLE `user_research`
  ADD PRIMARY KEY (`res_id`),
  ADD UNIQUE KEY `res_id_UNIQUE` (`res_id`),
  ADD UNIQUE KEY `res_index_UNIQUE` (`res_index`),
  ADD UNIQUE KEY `res_mail` (`res_mail`),
  ADD KEY `user_research_ibfk_1` (`res_center`);

--
-- Indexes for table `vars`
--
ALTER TABLE `vars`
  ADD PRIMARY KEY (`id_dia`,`pat_id`,`id_tipo_toma`) USING BTREE,
  ADD KEY `vars_ibfk_1` (`pat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `antibioticos_usados`
--
ALTER TABLE `antibioticos_usados`
  MODIFY `index_prescrito` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `diseases`
--
ALTER TABLE `diseases`
  MODIFY `dis_index` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historial_descargas`
--
ALTER TABLE `historial_descargas`
  MODIFY `index_descarga` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `hospital_docs`
--
ALTER TABLE `hospital_docs`
  MODIFY `hosp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lista_micros`
--
ALTER TABLE `lista_micros`
  MODIFY `microor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000043;

--
-- AUTO_INCREMENT for table `lista_vars`
--
ALTER TABLE `lista_vars`
  MODIFY `index_var` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_antibioticos`
--
ALTER TABLE `list_antibioticos`
  MODIFY `ant_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `list_marcadores`
--
ALTER TABLE `list_marcadores`
  MODIFY `marcador_index` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `microorganismos`
--
ALTER TABLE `microorganismos`
  MODIFY `index_test` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1187;

--
-- AUTO_INCREMENT for table `micro_tests`
--
ALTER TABLE `micro_tests`
  MODIFY `test_index` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `pat_index` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=549;

--
-- AUTO_INCREMENT for table `research_centers`
--
ALTER TABLE `research_centers`
  MODIFY `center_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reset_pwd_usuarios`
--
ALTER TABLE `reset_pwd_usuarios`
  MODIFY `id_reset` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tto_terapia`
--
ALTER TABLE `tto_terapia`
  MODIFY `index_tto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `user_docs`
--
ALTER TABLE `user_docs`
  MODIFY `doc_index` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_research`
--
ALTER TABLE `user_research`
  MODIFY `res_index` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antibioticos_usados`
--
ALTER TABLE `antibioticos_usados`
  ADD CONSTRAINT `fk_ant` FOREIGN KEY (`ant_id`) REFERENCES `list_antibioticos` (`ant_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pat` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`pat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `caso`
--
ALTER TABLE `caso`
  ADD CONSTRAINT `fk_caso_clinical_finding` FOREIGN KEY (`cl_find_id`) REFERENCES `clinical_finding` (`cl_find_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Caso_patient1` FOREIGN KEY (`case_pat_id`) REFERENCES `patients` (`pat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_microorg` FOREIGN KEY (`agent_etio`) REFERENCES `lista_micros` (`microor_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `control`
--
ALTER TABLE `control`
  ADD CONSTRAINT `fk_Control_patient1` FOREIGN KEY (`control_pat_id`) REFERENCES `patients` (`pat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diseases`
--
ALTER TABLE `diseases`
  ADD CONSTRAINT `id_finding` FOREIGN KEY (`dis_id`) REFERENCES `clinical_finding` (`cl_find_id`);

--
-- Constraints for table `historial_descargas`
--
ALTER TABLE `historial_descargas`
  ADD CONSTRAINT `fk_usuarios` FOREIGN KEY (`usuario`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `list_marcadores`
--
ALTER TABLE `list_marcadores`
  ADD CONSTRAINT `fk_hallazgo` FOREIGN KEY (`hallazgo_asociado`) REFERENCES `clinical_finding` (`cl_find_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vars` FOREIGN KEY (`codigo_var`) REFERENCES `lista_vars` (`index_var`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `manejo_inicial`
--
ALTER TABLE `manejo_inicial`
  ADD CONSTRAINT `fk_Manejo_inicial_Caso1` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`pat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `microorganismos`
--
ALTER TABLE `microorganismos`
  ADD CONSTRAINT `fk_id_agentes_etio` FOREIGN KEY (`microorg_id`) REFERENCES `lista_micros` (`microor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_microorganismos_Caso1` FOREIGN KEY (`test_id`) REFERENCES `micro_tests` (`test_index`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_patient_case` FOREIGN KEY (`case_pat_id`) REFERENCES `patients` (`pat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `fk_pat_doctor` FOREIGN KEY (`pat_doc_assigned`) REFERENCES `user_docs` (`doc_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sex` FOREIGN KEY (`pat_sex`) REFERENCES `codigo_sexo` (`sex_codes`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `pat_risk_factors`
--
ALTER TABLE `pat_risk_factors`
  ADD CONSTRAINT `fk_id_pat_risk_factors` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`pat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reset_pwd_usuarios`
--
ALTER TABLE `reset_pwd_usuarios`
  ADD CONSTRAINT `fk_mail_reset` FOREIGN KEY (`email`) REFERENCES `users` (`user_mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tto_terapia`
--
ALTER TABLE `tto_terapia`
  ADD CONSTRAINT `fk_pat_id` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`pat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userlog`
--
ALTER TABLE `userlog`
  ADD CONSTRAINT `fk_UserLog_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_users_roles1` FOREIGN KEY (`user_rol`) REFERENCES `users_roles` (`rol_id`);

--
-- Constraints for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD CONSTRAINT `admin_id` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_docs`
--
ALTER TABLE `user_docs`
  ADD CONSTRAINT `doc_id` FOREIGN KEY (`doc_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_doc_hosp` FOREIGN KEY (`doc_hospital`) REFERENCES `hospital_docs` (`hosp_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mail_doc` FOREIGN KEY (`doc_mail`) REFERENCES `users` (`user_mail`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_research`
--
ALTER TABLE `user_research`
  ADD CONSTRAINT `fk_mail_res` FOREIGN KEY (`res_mail`) REFERENCES `users` (`user_mail`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_res_id` FOREIGN KEY (`res_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_research_ibfk_1` FOREIGN KEY (`res_center`) REFERENCES `research_centers` (`center_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `vars`
--
ALTER TABLE `vars`
  ADD CONSTRAINT `vars_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`pat_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
