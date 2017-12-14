-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2017 at 05:10 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `events`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE `account_type` (
  `Account_type` int(11) DEFAULT NULL,
  `Type` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`Account_type`, `Type`) VALUES
(1, 'Admin'),
(2, 'Standard User');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_id` int(11) DEFAULT NULL,
  `Category` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_id`, `Category`) VALUES
(1, 'Classical'),
(2, 'Rock'),
(3, 'Pop'),
(4, 'Jazz'),
(5, 'EDM'),
(6, 'RAP');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `Title` varchar(99) DEFAULT NULL,
  `Event_id` int(11) DEFAULT NULL,
  `Category_id` int(11) DEFAULT NULL,
  `Artist` varchar(999) NOT NULL,
  `Description` varchar(999) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`Title`, `Event_id`, `Category_id`, `Artist`, `Description`) VALUES
('Bruno Mars - 24K Magic World Tour 2017', 101, 3, 'Bruno Mars', 'Bruno Mars will perform live in United States, United Kingdom, Malaysia and Hong Kong'),
('Mayday World Tour', 102, 3, 'Mayday', 'Mayday will perform live in the United Kingdom, Australia, Singapore, China and Taiwan'),
('Taylor Swift World Tour', 103, 3, 'Taylor Swift', 'Taylor Swift will perform live in United States, United Kingdom and Germany'),
('Jay Chou - The Invincible', 104, 3, 'Jay Chou', 'Jay Chou will perform live in the United Kingdom, London.'),
('Justin Bieber - Purpose World Tour 2017', 105, 3, 'Justin Bieber', 'Justin Bieber will perform live in United States, Maxico and Peru'),
('Taylor Swift-The Red Tour', 106, 3, 'Taylor Swift', 'Taylor Swift will perform live in Washington, Arizona and Seattle'),
('Bruno Mars - UK Tour', 107, 3, 'Bruno Mars', 'Bruno Mars will perform in Manchester, Leicester and London of the United Kingdom'),
('Adele Visits London', 108, 3, 'Adele', 'Adele will perform live in the United Kingdom, London'),
('hi', 109, 1, 'hi', 'hi'),
('hi', 110, 1, 'hi', 'hi');

-- --------------------------------------------------------

--
-- Table structure for table `organiser`
--

CREATE TABLE `organiser` (
  `Event_id` int(11) DEFAULT NULL,
  `User_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organiser`
--

INSERT INTO `organiser` (`Event_id`, `User_id`) VALUES
(101, 1),
(102, 2),
(103, 1),
(104, 2),
(105, 3),
(106, 1),
(107, 3),
(108, 6),
(110, 1);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `Event_id` int(11) DEFAULT NULL,
  `User_id` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Description` varchar(999) DEFAULT NULL,
  `Review_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`Event_id`, `User_id`, `Rating`, `Description`, `Review_date`) VALUES
(101, 1, 8, 'NIL', '2017-11-01'),
(101, 2, 4, 'The Seats are uncomfortable', '2017-11-10'),
(101, 3, 7, 'Amazing Performance', '2017-11-08'),
(101, 4, 6, 'Really enjoyed myself', '2017-10-31'),
(101, 5, 4, 'Not up to expectations', '2017-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `Sale_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Show_id` int(11) NOT NULL,
  `Tickets_brought` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`Sale_id`, `User_id`, `Show_id`, `Tickets_brought`) VALUES
(1, 1, 1, 6),
(2, 2, 1, 3),
(3, 3, 1, 2),
(4, 4, 1, 3),
(5, 5, 1, 3),
(6, 2, 2, 3),
(7, 5, 2, 3),
(8, 6, 2, 5),
(9, 1, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `show`
--

CREATE TABLE `show` (
  `Event_id` int(11) DEFAULT NULL,
  `Show_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `show`
--

INSERT INTO `show` (`Event_id`, `Show_id`) VALUES
(101, 1),
(101, 2),
(101, 3),
(101, 4),
(102, 5),
(102, 6),
(102, 7),
(102, 8),
(103, 9),
(103, 10),
(103, 11),
(104, 12),
(105, 13),
(105, 14),
(105, 15),
(106, 16),
(106, 17),
(106, 18),
(107, 19),
(107, 20),
(107, 21),
(108, 22),
(110, 23);

-- --------------------------------------------------------

--
-- Table structure for table `show_details`
--

CREATE TABLE `show_details` (
  `Show_id` int(11) DEFAULT NULL,
  `Venue` varchar(99) DEFAULT NULL,
  `Start_time` time DEFAULT NULL,
  `End_time` time DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Ticket_Num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `show_details`
--

INSERT INTO `show_details` (`Show_id`, `Venue`, `Start_time`, `End_time`, `Date`, `Ticket_Num`) VALUES
(1, 'United States, Washington', '19:00:00', '21:00:00', '2017-10-27', 18),
(2, 'United Kingdom, London', '19:00:00', '21:00:00', '2017-10-28', 20),
(3, 'Malaysia, Kuala Lumpur', '18:00:00', '21:00:00', '2017-10-29', 30),
(4, 'Hong Kong', '20:00:00', '23:00:00', '2017-10-30', 70),
(5, 'United Kingdom, London', '18:00:00', '21:00:00', '2017-10-12', 90),
(6, 'Australia, Melbourne', '20:00:00', '22:00:00', '2017-10-14', 75),
(7, 'Singapore', '20:00:00', '23:00:00', '2017-10-15', 85),
(8, 'Taiwan, Taipei', '19:00:00', '22:00:00', '2017-10-17', 65),
(9, 'United States, Arizona', '19:00:00', '23:00:00', '2017-09-12', 100),
(10, 'United Kingdom, Machester', '20:00:00', '23:00:00', '2017-09-27', 250),
(11, 'Germany, Berlin', '21:00:00', '22:30:00', '2017-10-01', 150),
(12, 'United Kingdom, London', '19:00:00', '22:00:00', '2017-10-29', 40),
(13, 'United States, Mississippi', '19:00:00', '23:00:00', '2017-10-31', 50),
(14, 'Mexico, Mexico City', '21:00:00', '22:30:00', '2017-11-14', 80),
(15, 'Peru, Lima', '19:00:00', '22:30:00', '2017-11-19', 125),
(16, 'United States, Washington', '19:00:00', '22:30:00', '2017-12-10', 185),
(17, 'United States, Arizona', '19:00:00', '22:30:00', '2017-12-17', 65),
(18, 'United States, Seattle', '19:00:00', '22:30:00', '2017-12-24', 215),
(19, 'United Kingdom, Machester', '20:00:00', '23:00:00', '2018-01-07', 310),
(20, 'United Kingdom, Leicester', '20:00:00', '23:00:00', '2018-01-13', 115),
(21, 'United Kingdom, London', '21:00:00', '24:00:00', '2018-01-20', 55),
(22, 'United Kingdom, London', '19:00:00', '22:00:00', '2017-12-16', 20),
(23, 'hi', '19:00:00', '21:00:00', '2017-12-21', 20);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `Show_id` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Sold_tickets` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`Show_id`, `Price`, `Sold_tickets`) VALUES
(1, 250, 17),
(2, 400, 19);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_id` int(11) DEFAULT NULL,
  `First_name` varchar(99) DEFAULT NULL,
  `Last_name` varchar(99) DEFAULT NULL,
  `Password` varchar(99) DEFAULT NULL,
  `Email` varchar(99) DEFAULT NULL,
  `Account_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_id`, `First_name`, `Last_name`, `Password`, `Email`, `Account_type`) VALUES
(1, 'Benjamin', 'Stark', 'Password1', 'ben_stark@gmail.com', 2),
(2, 'Tony', 'Lim', 'Password2', 'tony_lim@rocketmail.com', 2),
(3, 'Henry', 'Reid', 'Password3', 'henry_reid@hotmail.com', 2),
(4, 'Jennifer', 'Atkinson', 'Password4', 'Jennifer_A@ucl.ac.uk', 2),
(5, 'Clara', 'Spencer', 'Password5', 'clara_spencer@live.com', 2),
(6, 'Yi Xin', 'Kan', 'kanyx96', 'kanyx96@gmail.com', 1),
(7, 'John', 'Lee', 'jlee', 'jlee@yahoo.com', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
