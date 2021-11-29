-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 29, 2021 at 11:26 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `vanguas2_homeprehensive`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `request_id` bigint(11) NOT NULL,
  `comment` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `covers`
--

CREATE TABLE `covers` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `cover_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `covers`
--

INSERT INTO `covers` (`id`, `code`, `cover_name`) VALUES
(1, '1001', 'Comprehensive'),
(2, '1002', 'Third Party'),
(3, '1003', 'Third Party Fire & Theft');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `mobile` varchar(13) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--


-- --------------------------------------------------------

--
-- Table structure for table `homeinsurances`
--

CREATE TABLE `homeinsurances` (
  `id` int(11) NOT NULL,
  `cover_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `homeinsurances`
--

INSERT INTO `homeinsurances` (`id`, `cover_name`) VALUES
(1, 'Building'),
(2, 'Content'),
(3, 'Building & Content');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `userid` varchar(10) NOT NULL,
  `buildinglocation` varchar(90) NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `cover` varchar(10) NOT NULL,
  `vusage` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `seat` int(11) NOT NULL,
  `value` double NOT NULL,
  `cubic` int(11) NOT NULL,
  `cfree` int(11) NOT NULL,
  `extra_tppd` int(11) NOT NULL,
  `excess` varchar(5) NOT NULL,
  `duration` int(11) NOT NULL,
  `currency` int(11) NOT NULL,
  `engine` varchar(70) DEFAULT NULL,
  `txtcontentvalue` double DEFAULT NULL,
  `txtbuildingvalue` double DEFAULT NULL,
  `homeinsurance` int(11) NOT NULL,
  `status` enum('complete','pending','unfollowed','failed') NOT NULL DEFAULT 'unfollowed',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requests`
--

-- --------------------------------------------------------

--
-- Table structure for table `usages`
--

CREATE TABLE `usages` (
  `id` int(11) NOT NULL,
  `usage_code` varchar(10) NOT NULL,
  `usage_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usages`
--

INSERT INTO `usages` (`id`, `usage_code`, `usage_name`) VALUES
(0, '', 'undefined'),
(1, '', 'X1(Private Vehicle(Individual))'),
(2, '', 'X1(Private Vehicle(Company))'),
(3, '', 'Taxi'),
(4, '', 'Hiring Cars'),
(5, '', 'Mini Bus(Up to 22 Seats)'),
(6, '', 'Maxi Bus(Greater Than 22 Seats)'),
(7, '', 'Motor Cycle'),
(8, '', 'Ambulance/Hearse'),
(9, '', 'Own Goods(3000 CC or Below)'),
(10, '', 'Own Goods(Above 3000 CC)'),
(11, '', 'Articulators/Tankers'),
(12, '', 'General Cartage(3000 CC or Below)'),
(13, '', 'General Cartage(Above 3000 CC)'),
(14, '', 'Special Type(On Site)'),
(15, '', 'Special Type(On Road)'),
(16, '', 'Trade Plate(Fitters)'),
(17, '', 'Trade Plate(Garages)'),
(18, '', 'Trade Plate(Clearers)');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` enum('1','2','3','4','5') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `first_name` varchar(120) NOT NULL,
  `last_name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `covers`
--
ALTER TABLE `covers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homeinsurances`
--
ALTER TABLE `homeinsurances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `usages`
--
ALTER TABLE `usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `usage_code` (`usage_code`),
  ADD KEY `usage_name` (`usage_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `covers`
--
ALTER TABLE `covers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `homeinsurances`
--
ALTER TABLE `homeinsurances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `usages`
--
ALTER TABLE `usages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
