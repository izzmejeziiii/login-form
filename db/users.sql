-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2022 at 08:56 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `form`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lname`, `gender`, `address`, `birthday`, `username`, `password`, `created`) VALUES
(32, 'Jezi Anne', 'Tobio', 'F', 'La Paz, Leyte', '2018-05-04', 'jezi', '$2y$10$oyD35HtSLa8GCHSc8jOddebGxE9jiPUGWrpy.CToN5FnUsrEJWCDC', '2022-05-17 11:08:07'),
(33, 'Alejandro', 'Diaz', 'M', 'Tacloban City', '2014-02-01', 'alejandro', '$2y$10$ja1RED8eFT23Ec9BRnliZuHIIiOcdPgxTQnV9zbGdKB3DPSMINUSS', '2022-05-17 11:27:13'),
(34, 'Mirabel', 'Madrigal', 'F', 'Leyte', '2022-05-26', 'mirabel', '$2y$10$Ev0G9GZr0qaQVsjufI/eC.ZLPUMaU0MFR/2snEG10ykRwlZEFsUeq', '2022-05-17 11:48:55'),
(35, 'Ricardo', 'Dalisay', 'M', 'Manila', '2022-05-27', 'ric', '$2y$10$17Xn8PBtKbFqHA.9ZgFfHuSOUV4/k9KFBZST39woZLWmdORtUIMRm', '2022-05-17 14:03:05'),
(36, 'Ricard', 'Den', 'M', 'Somewhere', '2022-05-11', 'card', '$2y$10$wl5DaQ6TuDx77513c42SB.Kt9UtCw/L2Zj98gMq6bGfXcQkgSqJaC', '2022-05-17 14:05:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
