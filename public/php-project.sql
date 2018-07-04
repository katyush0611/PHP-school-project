-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2018 at 07:51 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php-project`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(4) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `img` varchar(250) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `img`, `description`) VALUES
(4875, 'JAVA ', 'java.png', 'Java is a general-purpose computer-programming language that is concurrent, class-based, object-oriented, and specifically designed to have as few implementation dependencies as possible. It is intended to let application developers \"write once, run anywhere\" (WORA), meaning that compiled Java code can run on all platforms that support Java without the need for recompilation.'),
(6933, ' PHP', 'phplogo.png', 'Hypertext Preprocessor (or simply PHP) is a server-side scripting language designed for web development but also used as a general-purpose programming language.'),
(7825, 'JS', '5b0aee9c1ba232.09099072.png', 'high-level, interpreted programming language. It is a language which is also characterized as dynamic, weakly typed, prototype-based and multi-paradigm. As a multi-paradigm language, JavaScript supports event-driven, functional, and imperative programming styles.'),
(8223, 'css 3', 'csslogo.png', 'Cascading Style Sheets - is a style sheet language used for describing the presentation of a document written in a markup language like HTML. CSS is a cornerstone technology of the World Wide Web, alongside HTML and JavaScript.'),
(9841, 'SQL', '5b0aef92118254.58459017.png', 'Structured Query Language - is a domain-specific language used in programming and designed for managing data held in a relational database management system, or for stream processing in a relational data stream management system . It is particularly useful in handling structured data where there are relations between different entities/variables of the data.');

-- --------------------------------------------------------

--
-- Table structure for table `exchange`
--

CREATE TABLE `exchange` (
  `course_id` int(4) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exchange`
--

INSERT INTO `exchange` (`course_id`, `student_id`) VALUES
(4875, 93),
(6933, 94),
(9841, 94),
(4875, 94),
(7825, 95),
(6933, 95),
(8223, 96),
(7825, 96),
(7825, 97),
(9841, 97),
(4875, 97),
(6933, 98),
(7825, 98),
(9841, 98),
(4875, 98);

-- --------------------------------------------------------

--
-- Table structure for table `premissions`
--

CREATE TABLE `premissions` (
  `premission` varchar(60) NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `premissions`
--

INSERT INTO `premissions` (`premission`, `name`, `username`, `password`) VALUES
('principal', 'Mr.Oscar', 'oscarbaby', 12345),
('sales', 'Vika Lepos', 'vikvik', 54321),
('teacher', 'Gary Bruce', 'garyy', 99999);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `img` varchar(250) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `img`, `phone`, `email`) VALUES
(93, 'Shani', '5b0aebd546dfe6.35302215.png', '0544456789', 'shani1010@gmail.com'),
(94, 'Mark', '5b0aec060d9fe5.51124092.png', '0502745689', '1mark1@mail.ru'),
(95, 'Ron', '5b0aec2d1b5c27.77545188.png', '0528256295', 'roooon123@walla.com'),
(96, 'Shelly', '5b0aec69bda2a3.20833328.png', '0548760912', 'shon@gmail.com'),
(97, 'Nataly', '5b0aec8ec94b82.03468949.png', '0504567889', 'sofovsds@gmail.com'),
(98, 'Shon', '5b0aeccd64e9d8.74153291.png', '0522745328', 'oscarar@walla.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exchange`
--
ALTER TABLE `exchange`
  ADD KEY `course_id` (`course_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exchange`
--
ALTER TABLE `exchange`
  ADD CONSTRAINT `exchange_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `exchange_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
