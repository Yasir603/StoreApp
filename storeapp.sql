-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2022 at 11:46 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `storeapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `admin_uid` varchar(50) NOT NULL,
  `avatar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `password`, `admin_uid`, `avatar`) VALUES
('yasir@gmail.com', '12345', 'bb428650-409b-4283-9299-e493770ab860', '165865630270982.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orderproducts`
--

CREATE TABLE `orderproducts` (
  `uid` varchar(50) NOT NULL,
  `order_uid` varchar(50) NOT NULL,
  `product_uid` varchar(50) NOT NULL,
  `quantity` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderproducts`
--

INSERT INTO `orderproducts` (`uid`, `order_uid`, `product_uid`, `quantity`) VALUES
('1e037522-6b93-4d59-8acb-06beb95c593b', '3a7d2b53-3d21-4783-b927-8d81dd701fc0', '2bf50a01-9641-4f3d-a9a9-aff89574e7a5', 2),
('3497bf02-330d-4d07-8995-b58fb05c4789', '6d10e616-51d1-4eb1-9a7f-be1c81231544', 'f5de6200-7eab-4ae8-b508-15c881eb7ec5', 2),
('d32c99b2-a7ca-4052-a045-44ee289ef091', 'ada043fc-95a8-4aed-b3a9-cc532ee3c507', '7025147a-e48a-48a0-8c53-71d4fe6ce793', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `uid` varchar(50) NOT NULL,
  `user_uid` varchar(50) NOT NULL,
  `state` varchar(10) NOT NULL,
  `order_dt` datetime NOT NULL,
  `payment_paid` int(50) NOT NULL,
  `payment_due` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`uid`, `user_uid`, `state`, `order_dt`, `payment_paid`, `payment_due`) VALUES
('3a7d2b53-3d21-4783-b927-8d81dd701fc0', '4bb27617-63ee-4579-bdaa-7e66a9252bc7', 'pending', '2022-07-28 12:31:07', 0, 0),
('6d10e616-51d1-4eb1-9a7f-be1c81231544', 'bd4c022e-918e-40df-a646-941ba51a89f4', 'pending', '2022-07-30 11:05:54', 3000, 1000),
('ada043fc-95a8-4aed-b3a9-cc532ee3c507', 'bd4c022e-918e-40df-a646-941ba51a89f4', 'pending', '2022-07-28 12:35:59', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_uid` varchar(50) NOT NULL,
  `p_name` varchar(20) NOT NULL,
  `quantity` int(50) NOT NULL,
  `pieces` int(50) NOT NULL,
  `sales_price` int(225) NOT NULL,
  `purchase_price` int(225) NOT NULL,
  `vendor_name` varchar(20) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_uid`, `p_name`, `quantity`, `pieces`, `sales_price`, `purchase_price`, `vendor_name`, `image`) VALUES
('2bf50a01-9641-4f3d-a9a9-aff89574e7a5', 'mouse', 4, 3, 150, 90, 'yasir', '165872973859392.pdf'),
('7025147a-e48a-48a0-8c53-71d4fe6ce793', 'keyboard', 2, 1, 200, 170, 'hamza', '165881882130721.jpg'),
('f5de6200-7eab-4ae8-b508-15c881eb7ec5', 'mobile', 4, 2, 2000, 1700, 'sameer', '165898204651190.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `address` varchar(30) NOT NULL,
  `user_uid` varchar(50) NOT NULL,
  `avatar` varchar(50) NOT NULL,
  `block` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `email`, `password`, `address`, `user_uid`, `avatar`, `block`) VALUES
('yasir', 'yasir@gmail.com', '12345', 'murree road islamabad ', '4bb27617-63ee-4579-bdaa-7e66a9252bc7', '165865673237314.jpg', 0),
('hamza', 'hamza@gmail.com', '123', 'rawalpindi', 'bd4c022e-918e-40df-a646-941ba51a89f4', '165883281052884.jpg', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_uid`);

--
-- Indexes for table `orderproducts`
--
ALTER TABLE `orderproducts`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
