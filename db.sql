-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 06, 2020 at 10:51 AM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dpoe`
--

-- --------------------------------------------------------

--
-- Table structure for table `bpmn_models`
--

CREATE TABLE `bpmn_models` (
  `id` int(11) NOT NULL,
  `filename` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bpmn_models`
--

INSERT INTO `bpmn_models` (`id`, `filename`) VALUES
(27, 'tollgate_b_bpmnio.bpmn'),
(31, 'AVP Part2.bpmn');

-- --------------------------------------------------------

--
-- Table structure for table `model_info`
--

CREATE TABLE `model_info` (
  `id` int(11) NOT NULL,
  `data_subject` text,
  `controller` text,
  `processor` text,
  `recipient` text,
  `third_party` text,
  `model_ref` int(11) DEFAULT NULL,
  `personal_data` text,
  `processing_task` text,
  `data_category` text,
  `purpose` text,
  `special_purpose` text,
  `consent` text,
  `clear_purpose` text,
  `unambiguous` text,
  `affirmative_action` text,
  `distinguishable` text,
  `specific` text,
  `withdrawable` text,
  `freely_given` text,
  `confidentiality` text,
  `integrity` text,
  `availability` text,
  `resilient` text,
  `pseudonimity` text,
  `data_minimization` text,
  `redundancies` text,
  `tested` text,
  `data_storage` text,
  `storage_limited` text,
  `technical_measures` text,
  `processing_log` text,
  `name` text,
  `contact_details` text,
  `personal_data_category` text,
  `data_storage_period` text,
  `technical_safeguards` text,
  `recipients` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `model_info`
--

INSERT INTO `model_info` (`id`, `data_subject`, `controller`, `processor`, `recipient`, `third_party`, `model_ref`, `personal_data`, `processing_task`, `data_category`, `purpose`, `special_purpose`, `consent`, `clear_purpose`, `unambiguous`, `affirmative_action`, `distinguishable`, `specific`, `withdrawable`, `freely_given`, `confidentiality`, `integrity`, `availability`, `resilient`, `pseudonimity`, `data_minimization`, `redundancies`, `tested`, `data_storage`, `storage_limited`, `technical_measures`, `processing_log`, `name`, `contact_details`, `personal_data_category`, `data_storage_period`, `technical_safeguards`, `recipients`) VALUES
(19, 'Car', 'Tollgate', NULL, 'Bank', NULL, 27, 'Payment info ', 'Request_payment', 'general', 'general', 'general', 'false', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'AV', 'PSP', NULL, NULL, NULL, 31, 'Parking service credential', '7._Request_parking', 'general', 'controller_legal_obligation', 'general', 'false', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bpmn_models`
--
ALTER TABLE `bpmn_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `model_info`
--
ALTER TABLE `model_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model_ref_2` (`model_ref`),
  ADD KEY `model_ref` (`model_ref`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bpmn_models`
--
ALTER TABLE `bpmn_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `model_info`
--
ALTER TABLE `model_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
