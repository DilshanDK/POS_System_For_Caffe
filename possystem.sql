-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 04:17 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `possystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminreg`
--

CREATE TABLE `adminreg` (
  `uName` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminreg`
--

INSERT INTO `adminreg` (`uName`, `password`) VALUES
('ati', 'zxc');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(20) NOT NULL,
  `quantity` int(10) NOT NULL,
  `img` varchar(255) NOT NULL,
  `isdelete` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemid`, `name`, `price`, `quantity`, `img`, `isdelete`) VALUES
(1, 'Cake ', 340, 6, '', 0),
(2, 'Rice', 230, 2, '', 0),
(3, 'Mango Juice ', 450, 5, '', 0),
(16, 'aba', 30, 4, '', 0),
(17, 'aba', 23, 6, '', 0),
(18, 'daba', 234, 2, '', 0),
(19, 'aba', 234, 3, '', 0),
(20, 'aba', 45, 2, '', 0),
(21, 'aba', 234, 4, '', 0),
(22, 'aba', 23, 6, '', 0),
(23, 'aba', 45, 2, '', 0),
(24, 'aba', 234, 4, '', 0),
(25, 'daba', 23, 4, '', 0),
(26, 'aba', 45, 2, '', 0),
(27, 'aba', 23, 6, '', 0),
(28, 'aba', 234, 2, '', 0),
(29, 'aba', 30, 3, '', 0),
(30, 'aba', 30, 2, '', 0),
(31, 'aba', 565, 2, '', 0),
(32, 'aba', 30, 6, '', 0),
(33, 'wwwsw', 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderid` int(20) NOT NULL,
  `uid` int(20) NOT NULL,
  `itemid` int(20) NOT NULL,
  `itemprice` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `totbill` int(20) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `isdelete` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderid`, `uid`, `itemid`, `itemprice`, `quantity`, `totbill`, `date`, `time`, `isdelete`) VALUES
(1, 1, 1, 34, 656, 34, '2024-03-22', '00:00:00', 0),
(2, 1, 1, 34, 5, 34, '2024-03-22', '00:00:00', 0),
(3, 1, 1, 10, 13, 10, '2024-03-22', '00:00:00', 0),
(4, 1, 1, 34, 5, 34, '2024-03-22', '00:00:00', 0),
(5, 1, 1, 34, 5, 0, '2024-03-22', '00:00:00', 0),
(6, 1, 1, 34, 5, 170, '2024-03-22', '00:00:00', 0),
(7, 4, 1, 34, 3, 102, '2024-03-22', '00:00:00', 0),
(8, 4, 5, 34, 6, 204, '2024-03-22', '00:00:00', 0),
(9, 1, 1, 565, 5, 2825, '2024-03-22', '00:00:00', 0),
(10, 1, 5, 565, 5, 2825, '2024-03-22', '00:00:00', 0),
(11, 1, 4, 45, 5, 225, '2024-03-22', '00:00:00', 0),
(12, 1, 2, 34, 8, 272, '2024-03-22', '00:00:00', 0),
(13, 1, 2, 34, 8, 272, '2024-03-22', '00:00:00', 0),
(14, 1, 2, 1, 23, 23, '2024-03-22', '00:00:00', 0),
(15, 1, 1, 34, 656, 22304, '2024-03-22', '00:00:00', 0),
(16, 1, 3, 34, 656, 22304, '2024-03-22', '00:00:00', 0),
(17, 1, 3, 34, 3, 102, '2024-03-22', '00:00:00', 0),
(18, 4, 1, 565, 6, 3390, '2024-03-22', '00:00:00', 0),
(19, 4, 7, 34, 5, 170, '2024-03-22', '00:00:00', 0),
(20, 4, 2, 34, 656, 22304, '2024-03-22', '00:00:00', 0),
(21, 1, 2, 34, 656, 22304, '2024-03-30', '00:00:00', 0),
(22, 1, 3, 34, 5, 170, '2024-04-01', '00:00:00', 0),
(23, 1, 1, 34, 5, 170, '2024-04-01', '00:00:00', 0),
(24, 1, 2, 34, 656, 22304, '2024-04-01', '00:00:00', 0),
(25, 1, 1, 34, 656, 22304, '2024-04-01', '00:00:00', 0),
(26, 1, 1, 34, 656, 22304, '2024-04-01', '00:00:00', 0),
(27, 1, 1, 34, 5, 170, '2024-04-01', '00:00:00', 0),
(28, 1, 1, 34, 5, 170, '2024-04-03', '00:00:00', 0),
(29, 1, 2, 565, 5, 2825, '2024-04-03', '00:00:00', 0),
(30, 1, 4, 565, 5, 2825, '2024-04-03', '00:00:00', 0),
(31, 1, 1, 34, 5, 170, '2024-04-07', '00:00:00', 0),
(32, 1, 2, 34, 5, 170, '2024-05-01', '00:00:00', 0),
(33, 1, 1, 34, 5, 170, '2024-05-01', '00:00:00', 0),
(34, 0, 1, 5, 7, 35, '2024-05-01', '00:00:00', 0),
(35, 0, 1, 5, 7, 35, '2024-05-01', '00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `userreg`
--

CREATE TABLE `userreg` (
  `uid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phoneNo` varchar(10) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `isdeleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userreg`
--

INSERT INTO `userreg` (`uid`, `name`, `email`, `address`, `phoneNo`, `pass`, `isdeleted`) VALUES
(1, 'dilshan', 'zxc@email.com', 'NO.123,Matale,Kandy', '0712345678', '$2y$10$DYCUKYZZfTNIAWQ7FnAFKupyUJIuueE3ACY2ZfBsa0exNg3eCc7Ra', 0),
(3, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', '0712345678', '$2y$10$rcCoZxBoTGrRiXR.lqPadOOqju5RbZyZUK3/SW2tnQjzgOQ3EoEVa', 0),
(4, 'nimal', 'abc@email.com', 'NO.123,Matale,Kandy', '0712345678', '$2y$10$p6js7M2/sX3Wgra306dlguJ1RAheI.wjZ9XTomx6SClhSNF3XFwQS', 0),
(5, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', '0712345678', '$2y$10$ClktS6r4n65kgLjbrKEDEORKGTM/QUcxV.j6eFZPO2lVOYaHHJNF2', 0),
(6, 'dilshan', 'abc@email.com', 'No 456,Kandy,Colombo', '0712345678', '$2y$10$AXXpQNesQfiRXe.zxC7gW.A8A6yicjPyWRBKiN//Iw8C5g/J31r2C', 0),
(7, 'dilshan', 'abc@email.com', 'No 456,Kandy,Colombo', '0712345678', '$2y$10$akvTTRD5dmYsY4cE.znutOIzYjCX.dAmU9rUmB9AlEQyBl8WTfMXO', 0),
(8, 'dilshan', 'zxc@email.com', 'NO.123,Matale,Kandy', '0712345678', '$2y$10$Cgb5NBmZNmYy8DJltw9CwerZq.4xUaXUsb.3CGQAKH3rnHRJBpHMy', 0),
(9, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', '23', '$2y$10$jhjScy4j/IA6kIJNGLSR0.VtRmWiXqM6G5Nsmm0UZfmF3qd0qHlPm', 0),
(10, 'DS036', 'abc@email.com', 'NO.123,Matale,Kandy', '23', '$2y$10$R9Vm89f9h/5WhAXTPELcA.exKObcnuBtcXh7p7uFuQqMZoeaAfnrq', 0),
(11, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', '23', '$2y$10$9.Mf2Am.B1Wrv1NirA4cZesxW6R6XyFQkm.14KWhyiPIraVnaFfcW', 0),
(12, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', '23', '$2y$10$2.u3AxlWVa1TGM6vzEoyN.rNQzdMufrR3CiQts8FrekE72Wt67MPC', 0),
(13, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', '23', '$2y$10$8FA3eNpS3YO.NgqyFtIIh.HqGWz7R7rG09r1PKTbDKzuvoLcgtVjG', 0),
(14, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', '23', '$2y$10$fmY2LMSEVF7.31IbvzhQceR5fZpDYm/hy.Gz4GQ0KOiDiF5vg/yye', 0),
(15, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', '23', '$2y$10$Yd1rrDG.n.wNNDsTJv3oRO5QLAfoI7wCzo/eJvHyeG1RC3YPoMZ72', 0),
(16, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', 's', '$2y$10$4uMgHLua6a8JQVYHDva9cO6baMqw8p9Gcbbm.99nsMrM17RESl6/.', 0),
(17, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', 's', '$2y$10$7DqwaGy4/w5.2wImRAVjh.4RndQ9mEICeosprs3fyZ2cayi9BYSey', 0),
(18, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', '23', '$2y$10$0AgV6RFOPeM/73l6a8s3cedEVq/dkuZ9U1sWCl5WOz1.yarkZcwHy', 0),
(19, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', 'DS', '$2y$10$lcbq3dRZqnoYmY1nQ21WJe120ksY7IwFimoYTxQU/VqR629Vgl/EC', 0),
(20, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', 's', '$2y$10$8J8F1E.wW3I2zCh6y.5/EOeQJg9efmDFLq8diiHbEcVgWjMrPS59W', 0),
(21, 'dilshan', 'abc@email.com', 'NO.123,Matale,Kandy', 's', '$2y$10$LsOE2apFuaFLUAonRVRJkO5FzlRhtQhiBuoj.C2YitSza3mgezBqa', 0),
(22, 'dilshan', '123@gmail.com', 'ati kandy', '12334556', '$2y$10$jPwrrDY.VmdB.upA5VLMRuDWbV45Hs7E5mtdXbiFnS/zLly6JkB6K', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderid`);

--
-- Indexes for table `userreg`
--
ALTER TABLE `userreg`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderid` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `userreg`
--
ALTER TABLE `userreg`
  MODIFY `uid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
