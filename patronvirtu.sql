-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jun 04, 2023 at 06:59 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patronvirtu`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `image` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `discount`, `description`, `quantity`, `category`, `image`) VALUES
(7, 'Game 6', 44.99, 0.00, 'Description of Game 6', 80, 'game', NULL),
(8, 'Game 7', 49.99, 0.00, 'Description of Game 7', 70, 'game', NULL),
(10, 'Game 9', 39.99, 0.00, 'Description of Game 9', 95, 'game', NULL),
(11, 'Game 10', 54.99, 0.00, 'Description of Game 10', 65, 'game', NULL),
(20, 'Dead Island 2', 59.99, 0.00, 'Survive the zombie apocalypse in the sunny and chaotic California, where you must fight hordes of undead to stay alive.', 5, 'playstation', 0x75706c6f6164732f6465616469736c616e64322e6a7067),
(21, 'DiRT Rally 2.0', 39.99, 0.00, 'Experience the thrill of intense rally racing as you navigate challenging tracks and compete against skilled drivers.', 15, 'playstation', 0x75706c6f6164732f446972742052616c6c7920322e6a7067),
(22, 'FIFA 23', 69.99, 0.00, 'Immerse yourself in the world of football with realistic gameplay, updated player rosters, and exciting multiplayer matches.', 20, 'playstation', 0x75706c6f6164732f6669666132332e6a7067),
(23, 'LEGO DC Super-Villains', 39.99, 0.00, 'Step into the shoes of iconic DC super-villains as you wreak havoc in a brick-filled open world and outsmart the heroes.', 8, 'playstation', 0x75706c6f6164732f6c65676f64632e6a7067),
(24, 'LEGO DC Super Heroes: Young Justice', 29.99, 0.00, 'Join the ranks of the Young Justice team and save the world in this action-packed LEGO adventure with your favorite DC superheroes.', 12, 'playstation', 0x75706c6f6164732f6c6f676f6463796f756e672e6a7067),
(25, 'Monster Hunter World', 59.99, 0.00, 'Embark on an epic hunting journey in a vast open world, where you track down colossal monsters and forge your legend as a skilled hunter.', 25, 'playstation', 0x75706c6f6164732f6d6f6e7374657268756e746572776f726c642e6a7067),
(26, 'No Man\'s Sky', 49.99, 0.00, 'Explore an infinite universe filled with unique planets, alien species, and breathtaking landscapes in this ambitious space exploration game.', 30, 'playstation', 0x75706c6f6164732f6e6f6d616e736b792e6a7067),
(27, 'Pavlov VR', 29.99, 0.00, 'Immerse yourself in intense virtual reality first-person shooter action as you compete against other players in various multiplayer game modes.', 6, 'playstation', 0x75706c6f6164732f7061766c6f762e6a7067),
(28, 'Project Car 3', 49.99, 0.00, 'Experience the ultimate racing simulation with realistic graphics, dynamic weather, and a wide selection of cars and tracks.', 10, 'playstation', 0x75706c6f6164732f70726f6a65637463617273332e6a7067),
(29, 'Playstation Deluxe 1 Month', 9.99, 0.00, 'Unlock premium features and exclusive content with the PlayStation Deluxe subscription for one month.', 100, 'playstation', 0x75706c6f6164732f70735f64656c757865316d2e6a7067),
(30, 'Playstation Deluxe 3 Month', 24.99, 0.00, 'Enjoy an extended three-month PlayStation Deluxe subscription with access to a variety of benefits and perks.', 100, 'playstation', 0x75706c6f6164732f70735f64656c757865336d2e6a7067),
(31, 'Playstation Deluxe 12 Month', 59.99, 0.00, 'Indulge in a year-long PlayStation Deluxe subscription and maximize your gaming experience with exclusive offers and rewards.', 100, 'playstation', 0x75706c6f6164732f70735f64656c75786531326d2e6a7067),
(32, 'Playstation Essential 1 Month', 4.99, 0.00, 'Get essential access to the PlayStation Network features and online multiplayer for one month.', 100, 'playstation', 0x75706c6f6164732f70735f657373656e7469616c5f316d2e6a7067),
(33, 'Playstation Essential 3 Month', 14.99, 0.00, 'Stay connected and enjoy three months of essential PlayStation Network benefits and online gaming.', 100, 'playstation', 0x75706c6f6164732f70735f657373656e7469616c5f336d2e6a7067),
(34, 'Playstation Essential 12 Month', 39.99, 0.00, 'Secure a full year of essential PlayStation Network services and elevate your online gaming experience.', 100, 'playstation', 0x75706c6f6164732f70735f657373656e7469616c5f31326d2e6a7067),
(35, 'Playstation Extra 1 Month', 14.99, 0.00, 'Upgrade your PlayStation Network account with extra perks and bonuses for one month.', 100, 'playstation', 0x75706c6f6164732f70735f6578747261316d2e6a7067),
(36, 'Playstation Extra 3 Month', 34.99, 0.00, 'Enhance your gaming with an extended three-month PlayStation Network subscription and enjoy extra privileges.', 100, 'playstation', 0x75706c6f6164732f70735f6578747261336d2e6a7067),
(37, 'Playstation Extra 12 Month', 99.99, 0.00, 'Unlock a full year of exclusive benefits and additional content with the PlayStation Extra subscription.', 100, 'playstation', 0x75706c6f6164732f70735f657874726131326d2e6a7067),
(38, 'Resident Evil 4', 39.99, 0.00, 'Face the horror once again as you take on the role of Leon Kennedy in the classic survival horror game that defined the genre.', 10, 'playstation', 0x75706c6f6164732f7265736964656e746576696c342e6a7067),
(44, 'Assassin\'s Creed 3', 49.99, 0.00, 'Embark on an epic journey as an assassin during the American Revolution and fight for justice and freedom.', 10, 'playstation', 0x75706c6f6164732f736e697070657273686f73742e6a7067),
(45, 'DETROIT', 25.00, NULL, 'this is a test', 80, 'steam', 0x75706c6f6164732f444554524f49542e6a7067),
(46, 'Xbox game pass1 month', 10.00, NULL, 'Xbox game pass1 month', 800, 'xbox', 0x75706c6f6164732f67616d6570617373316d2e6a7067),
(47, 'call of duty', 25.00, NULL, 'call of duty test', 800, 'xbox', 0x75706c6f6164732f63616c6c6f66647574792e6a7067),
(48, 'diablo.jpg', 40.00, NULL, '', 50, 'xbox', 0x75706c6f6164732f646961626c6f2e6a7067),
(49, 'fortnite', 10.00, NULL, '', 300, 'xbox', 0x75706c6f6164732f666f72746e6974652e6a7067),
(50, 'forza 5 horizon', 48.00, NULL, '', 200, 'xbox', 0x75706c6f6164732f666f727a6135686f72697a6f6e2e6a7067),
(51, 'DRAGON BALL', 16.00, NULL, '', 200, 'steam', 0x75706c6f6164732f445241474f4e42414c4c2e6a7067),
(52, 'fallout', 80.00, NULL, '', 10, 'steam', 0x75706c6f6164732f66616c6c6f75742e6a7067),
(53, 'dying light 2', 54.00, NULL, '', 80, 'steam', 0x75706c6f6164732f6479696e676c69676874322e6a7067),
(54, 'chivalry', 61.00, NULL, '', 54, 'steam', 0x75706c6f6164732f63686976616c72792e6a7067),
(55, 'avast premium', 5.00, NULL, '', 2000, 'security', 0x75706c6f6164732f61766173747072656d69756d2e6a706567),
(56, 'mcafee antivirus', 5.00, NULL, '', 3000, 'security', 0x75706c6f6164732f6d63616665652e6a706567),
(57, 'file center', 10.00, NULL, '', 200, 'security', 0x75706c6f6164732f66696c6563656e7465722e6a706567),
(58, 'trend micro', 25.00, NULL, '', 500, 'security', 0x75706c6f6164732f7472656e646d6963726f2e6a706567),
(59, 'avg ultimate 10 device', 19.00, NULL, '', 200, 'security', 0x75706c6f6164732f617667756c74696d61746531306465766963652e6a706567);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `code`) VALUES
(5, 'moha', 'fcbvarma0@gmail.com', '968574d8ce4e917702cf397e1899db37', '457b96c2bf43bb87e8278640d62d30c1'),
(6, 'mohamed', 'fcbvarma11@gmail.com', '968574d8ce4e917702cf397e1899db37', 'c39173aef77d6a64f32c83971a356766'),
(17, 'mansourmohamedofficiel@gmail.com', 'mansourmohamedofficiel@gmail.com', '1aa60e5dc75533a17a52c5d49084f0e2', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
