-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2020 at 01:23 PM
-- Server version: 5.7.30-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.6

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
  `legal_ground` text,
  `legal_ground_special_category` text,
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
  `purpose` text,
  `contact_details` text,
  `personal_data_category` text,
  `data_storage_period` text,
  `security_measures` text,
  `third_countries_transfer` text,
  `recipients` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `model_info`
--
ALTER TABLE `model_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
