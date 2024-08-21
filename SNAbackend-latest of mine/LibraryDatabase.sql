-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2024 at 05:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `book_auth` varchar(255) NOT NULL,
  `book_sub` int(11) NOT NULL,
  `book_qty` int(11) NOT NULL,
  `is_archived` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_title`, `book_auth`, `book_sub`, `book_qty`, `is_archived`) VALUES
(1, 'English For You and Me', 'Lee Silvestre', 1, 1, 0),
(2, 'Python For You And Me', 'Loudel Manaloto', 2, 10, 0),
(3, 'Baby Shark', 'Ehdsell John Apan', 3, 10, 0),
(5, 'Physics For You And Me', 'Seann Datu', 3, 19, 0),
(6, 'Calculus II For You And Me', 'Jahnin Santiago', 4, 35, 0),
(7, 'PHP Laravel Fundamentals', 'Maam Sharmaine', 2, 41, 0),
(8, 'Vue.js For You And Me', 'Noel Ervas', 2, 10, 0),
(9, 'Node.js Fundamentals', 'Denise Lou Punzalan', 2, 25, 0),
(10, 'Math 2', 'Denris Provido', 4, 1, 0),
(12, 'Math 1', 'Aulwen Dizon', 4, 20, 0),
(17, 'Noli Me Tangere', 'Jose Rizal', 5, 49, 0),
(18, 'El Filibusterismo', 'Jose Rizal', 5, 50, 0),
(19, 'Ang Ibong Adarna', 'Huseng Sisiw', 5, 21, 0),
(20, 'Patron Saints of Nothing', 'Randy Ribay', 5, 10, 0),
(21, 'What is Love?', 'Twice', 6, 100, 0),
(23, 'Magnetic', 'Illit', 6, 50, 0),
(27, 'Whatchu Need', 'UNIS', 6, 20, 0),
(28, 'Jollibee', 'Aulwen', 7, 100, 0),
(29, 'McDonals', 'Gericho', 7, 10, 0),
(30, 'Consonants', 'Joshua Tumbocon', 1, 15, 0),
(31, 'Vowels', 'Whacky Dedase', 1, 12, 0),
(32, 'Databases', 'Maria Clara', 2, 1, 0),
(33, 'Adjectives', 'Zaira Mae Reyes', 1, 15, 0),
(34, 'What is Laravel?', 'Christian Lloyd Pingue', 2, 28, 0),
(35, 'Planets', 'Jezareel Truelen', 3, 30, 1),
(36, 'Solar System', 'Gericho Ladrillo', 3, 50, 1),
(37, 'SQL', 'Sudo', 2, 10, 1),
(38, 'Nouns', 'Lee', 1, 5, 1),
(39, 'The Little Match Girl', 'Seann Datu', 1, 10, 0),
(40, 'The Little Princess', 'Jomar', 1, 10, 1),
(41, 'Ang Kahibangan Ni Silvestre', 'Jordan Magbanua', 11, 100, 0);

-- --------------------------------------------------------

--
-- Table structure for table `book_category`
--

CREATE TABLE `book_category` (
  `book_sub` int(11) NOT NULL,
  `categ_name` varchar(255) NOT NULL,
  `is_archived` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_category`
--

INSERT INTO `book_category` (`book_sub`, `categ_name`, `is_archived`) VALUES
(1, 'English', 0),
(2, 'Programming', 0),
(3, 'Science', 0),
(4, 'Mathematics', 0),
(5, 'Literature', 0),
(6, 'Kpop', 0),
(7, 'Fast Food', 0),
(8, 'Cats', 1),
(9, 'Dogs', 1),
(10, 'Filipino', 0),
(11, 'History', 0),
(12, 'Horror', 1);

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `borrow_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `borrowed_date` date NOT NULL DEFAULT curdate(),
  `return_duedate` date NOT NULL DEFAULT (curdate() + interval 3 day),
  `borrow_status` int(11) NOT NULL DEFAULT 0,
  `access_no` varchar(255) NOT NULL,
  `return_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_books`
--

INSERT INTO `borrowed_books` (`borrow_id`, `book_id`, `student_id`, `borrowed_date`, `return_duedate`, `borrow_status`, `access_no`, `return_date`) VALUES
(1, 1, 202110879, '0000-00-00', '2024-04-27', 2, '101', '2024-04-30 00:00:00'),
(2, 1, 202110879, '2024-04-09', '2024-07-27', 2, '102', '2024-04-30 00:00:00'),
(3, 1, 202110879, '2024-04-24', '2024-07-27', 2, '103', '2024-04-30 00:00:00'),
(4, 3, 202110879, '2024-04-24', '2024-07-27', 2, '104', '2024-04-30 00:00:00'),
(5, 7, 202110002, '2024-04-30', '2024-10-30', 2, '234', '2024-04-30 00:00:00'),
(6, 7, 202110002, '2024-04-30', '2024-10-30', 2, '209', '2024-04-30 00:00:00'),
(7, 7, 202110002, '2024-04-30', '2024-10-30', 2, '564', '2024-04-30 00:00:00'),
(11, 7, 202110879, '2024-04-30', '2024-10-30', 2, '666', '2024-04-30 00:00:00'),
(12, 7, 202110879, '2024-04-30', '2024-10-30', 2, '999', '2024-04-30 00:00:00'),
(13, 7, 202110879, '2024-04-30', '2024-10-30', 2, '111', '2024-04-30 00:00:00'),
(16, 7, 202110879, '2024-04-30', '2024-10-30', 2, '222', '2024-05-01 00:00:00'),
(17, 7, 202110002, '2024-04-30', '2024-10-30', 2, '333', '2024-05-01 00:00:00'),
(18, 7, 202110879, '2024-04-30', '2024-10-30', 2, '444', '2024-05-01 00:00:00'),
(19, 10, 202110879, '2024-04-30', '2024-10-30', 2, '111', '2024-05-01 00:00:00'),
(20, 10, 202110879, '2024-04-30', '2024-10-30', 2, '222', '2024-05-01 00:00:00'),
(21, 10, 202110002, '2024-04-30', '2024-10-30', 2, '333', '2024-05-01 00:00:00'),
(22, 10, 202110879, '2024-04-30', '2024-10-30', 2, '444', '2024-05-01 00:00:00'),
(23, 10, 202110879, '2024-04-30', '2024-10-30', 2, '123', '2024-05-01 00:00:00'),
(24, 1, 202110879, '2024-04-30', '2024-10-30', 2, '102', '2024-05-02 00:00:00'),
(25, 1, 202110879, '2024-04-30', '2024-10-30', 2, '345', '2024-05-02 00:00:00'),
(26, 1, 202110879, '2024-05-02', '2024-11-02', 2, '101', '2024-05-02 00:00:00'),
(27, 1, 202110879, '2024-05-02', '2024-11-02', 2, '101', '2024-05-02 00:00:00'),
(28, 1, 202110879, '2024-05-02', '2024-11-02', 2, '101', '2024-05-02 00:00:00'),
(29, 1, 202110879, '2024-05-02', '2024-11-02', 2, '101', '2024-05-02 00:00:00'),
(30, 2, 202110002, '2024-05-02', '2024-11-02', 2, '101', '2024-05-02 00:00:00'),
(35, 2, 202110002, '2024-05-02', '2024-11-02', 2, '102', '2024-05-02 00:00:00'),
(36, 2, 202110879, '2024-05-02', '2024-11-02', 2, '102', '2024-05-02 00:00:00'),
(38, 10, 202110002, '2024-05-02', '2024-11-02', 2, '111', '2024-05-02 00:00:00'),
(39, 10, 202110879, '2024-05-02', '2024-11-02', 2, '666', '2024-05-02 00:00:00'),
(40, 9, 202110879, '2024-05-02', '2024-11-02', 2, '111', '2024-05-02 00:00:00'),
(41, 10, 202110879, '2024-05-02', '2024-11-02', 2, '111', '2024-05-02 00:00:00'),
(43, 1, 202110879, '2024-05-02', '2024-11-02', 2, '101', '2024-05-02 00:00:00'),
(44, 2, 202110879, '2024-05-02', '2024-11-02', 2, '102', '2024-05-03 00:00:00'),
(45, 5, 202110002, '2024-05-02', '2024-11-02', 2, '555', '2024-05-03 00:00:00'),
(46, 7, 202110879, '2024-05-02', '2024-11-02', 2, '911', '2024-05-02 00:00:00'),
(47, 10, 202110879, '2024-05-02', '2024-11-02', 2, '666', '2024-05-02 00:00:00'),
(48, 1, 202110879, '2024-05-02', '2024-11-02', 2, '100', '2024-05-02 00:00:00'),
(49, 1, 202110879, '2024-05-02', '2024-11-02', 2, '101', '2024-05-02 00:00:00'),
(50, 1, 202110879, '2024-05-02', '2024-11-02', 2, '111', '2024-05-02 00:00:00'),
(51, 10, 202110879, '2024-05-02', '2024-11-02', 2, '101', '2024-05-03 00:00:00'),
(52, 12, 202110002, '2024-05-02', '2024-11-02', 2, '111', '2024-05-02 00:00:00'),
(53, 5, 202110879, '2024-05-02', '2024-11-02', 2, '666', '2024-05-02 00:00:00'),
(54, 1, 202110879, '2024-05-03', '2024-11-03', 2, '111', '2024-05-03 00:00:00'),
(55, 1, 202110002, '2024-05-03', '2024-11-03', 2, '111', '2024-05-03 00:00:00'),
(56, 1, 202110879, '2024-05-03', '2024-11-03', 2, '111', '2024-05-03 07:54:14'),
(57, 1, 202110879, '2024-05-03', '2024-11-03', 2, '222', '2024-05-03 08:07:01'),
(58, 1, 202110879, '2024-05-03', '2024-05-06', 2, '101', '2024-05-03 16:42:32'),
(65, 1, 202110879, '2024-05-03', '2024-05-06', 2, '111', '2024-05-03 20:00:52'),
(66, 1, 202110879, '2024-05-03', '2024-05-06', 2, '6875', '2024-05-03 20:06:09'),
(67, 2, 202110879, '2024-05-03', '2024-05-06', 0, '1234', NULL),
(68, 10, 202110002, '2024-05-03', '0000-00-00', 2, '5678', '2024-05-03 20:14:08'),
(69, 5, 202110879, '2024-05-03', '2024-05-06', 2, '33', '2024-05-06 14:12:45'),
(70, 10, 202110878, '2024-05-03', '2024-05-06', 2, '666', '2024-05-04 01:11:35'),
(71, 10, 202110878, '2024-05-04', '2024-05-07', 2, '555', '2024-05-04 01:16:44'),
(72, 10, 202110878, '2024-05-04', '2024-05-07', 2, '555', '2024-05-04 01:21:06'),
(73, 10, 202110878, '2024-05-04', '2024-05-07', 2, '678', '2024-05-04 01:22:27'),
(74, 2, 202110878, '2024-05-04', '2024-05-07', 2, '1234', '2024-05-04 18:51:09'),
(75, 1, 202110878, '2024-05-04', '2024-05-07', 2, '123456', '2024-05-04 18:51:02'),
(76, 3, 202110879, '2024-05-04', '2024-05-07', 2, '333', '2024-05-04 18:48:28'),
(77, 10, 202110878, '2024-05-04', '2024-05-07', 2, '5678', '2024-05-06 13:46:56'),
(78, 10, 202110879, '2024-05-05', '2024-05-08', 0, '1620111723163', NULL),
(79, 2, 202110879, '2024-05-06', '2024-05-09', 2, '10', '2024-05-06 14:03:45'),
(80, 2, 202110879, '2024-05-06', '2024-05-09', 2, '555', '2024-05-06 01:41:26'),
(81, 3, 202110878, '2024-05-06', '2024-05-09', 2, '1234', '2024-05-06 13:46:50'),
(82, 34, 202110879, '2024-05-06', '2024-05-09', 2, '1234', '2024-05-06 13:38:45'),
(83, 2, 202110878, '2024-05-06', '2024-05-09', 2, '1234', '2024-05-06 14:05:37');

--
-- Triggers `borrowed_books`
--
DELIMITER $$
CREATE TRIGGER `update_borrow_status` BEFORE UPDATE ON `borrowed_books` FOR EACH ROW BEGIN
    IF NEW.borrow_status = 0 AND NOW() > NEW.return_duedate THEN
        SET NEW.borrow_status = 1;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_library_status` AFTER INSERT ON `borrowed_books` FOR EACH ROW BEGIN
    DECLARE borrow_count INT;
    
    -- Count the number of borrow records with borrow_status 0 or 1 for the affected student_id
    SELECT COUNT(*)
    INTO borrow_count
    FROM borrowed_books
    WHERE student_id = NEW.student_id AND borrow_status IN (0, 1);
    
    -- Update the status in library_status based on the borrow_count
    UPDATE library_status
    SET status = CASE
                    WHEN borrow_count > 0 THEN 'Not Yet Cleared'
                    ELSE 'Cleared'
                 END
    WHERE student_id = NEW.student_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_library_status_update` AFTER UPDATE ON `borrowed_books` FOR EACH ROW BEGIN
    DECLARE borrow_count INT;
    
    -- Count the number of borrow records with borrow_status 0 or 1 for the affected student_id
    SELECT COUNT(*)
    INTO borrow_count
    FROM borrowed_books
    WHERE student_id = NEW.student_id AND borrow_status IN (0, 1);
    
    -- Update the status in library_status based on the borrow_count
    UPDATE library_status
    SET status = CASE
                    WHEN borrow_count > 0 THEN 'Not Yet Cleared'
                    ELSE 'Cleared'
                 END
    WHERE student_id = NEW.student_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_return_date` BEFORE UPDATE ON `borrowed_books` FOR EACH ROW BEGIN
    IF NEW.borrow_status = 2 THEN
        SET NEW.return_date = NOW();
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_borrow`
--

CREATE TABLE `faculty_borrow` (
  `borrow_id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `borrowed_date` date NOT NULL DEFAULT curdate(),
  `return_duedate` date NOT NULL DEFAULT (curdate() + interval 3 day),
  `borrow_status` int(11) NOT NULL DEFAULT 0,
  `access_no` varchar(255) NOT NULL,
  `return_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_borrow`
--

INSERT INTO `faculty_borrow` (`borrow_id`, `book_id`, `id`, `borrowed_date`, `return_duedate`, `borrow_status`, `access_no`, `return_date`) VALUES
(2, 19, 1, '2024-05-03', '2024-05-06', 2, '111', '2024-05-03 16:29:53'),
(3, 10, 2, '2024-05-03', '2024-05-06', 2, '111', '2024-05-03 17:12:49'),
(4, 2, 2, '2024-05-03', '2024-05-06', 0, '333', NULL),
(5, 10, 1, '2024-05-03', '2024-05-06', 1, '666', NULL),
(6, 5, 1, '2024-05-03', '2024-05-06', 0, '555', NULL),
(7, 6, 2, '2024-05-03', '0000-00-00', 2, '666', '2024-05-04 01:39:38'),
(8, 7, 1, '2024-05-03', '0000-00-00', 2, '777', '2024-05-04 01:39:35'),
(9, 10, 1, '2024-05-04', '2024-05-07', 2, '666', '2024-05-04 01:41:22'),
(10, 10, 2, '2024-05-04', '2024-05-07', 2, '109', '2024-05-04 01:41:15'),
(11, 2, 1, '2024-05-06', '2024-05-09', 2, '1234', '2024-05-06 10:52:44');

--
-- Triggers `faculty_borrow`
--
DELIMITER $$
CREATE TRIGGER `update_faculty_borrow_status` BEFORE UPDATE ON `faculty_borrow` FOR EACH ROW BEGIN
    IF NEW.borrow_status = 0 AND NOW() > NEW.return_duedate THEN
        SET NEW.borrow_status = 1;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_faculty_return_date` BEFORE UPDATE ON `faculty_borrow` FOR EACH ROW BEGIN
    IF NEW.borrow_status = 2 THEN
        SET NEW.return_date = NOW();
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `librarian`
--

CREATE TABLE `librarian` (
  `lib_id` int(11) NOT NULL,
  `lib_email` varchar(255) NOT NULL,
  `lib_pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `librarian`
--

INSERT INTO `librarian` (`lib_id`, `lib_email`, `lib_pass`) VALUES
(1, 'libraryadmin@gmail.com', '@1234567');

-- --------------------------------------------------------

--
-- Table structure for table `library_status`
--

CREATE TABLE `library_status` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` enum('Not Yet Cleared','Cleared') NOT NULL DEFAULT 'Cleared'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library_status`
--

INSERT INTO `library_status` (`id`, `student_id`, `status`) VALUES
(4, 202110002, 'Cleared'),
(5, 202110878, 'Cleared'),
(6, 202110879, 'Not Yet Cleared');

-- --------------------------------------------------------


--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `fk_book_sub` (`book_sub`);

--
-- Indexes for table `book_category`
--
ALTER TABLE `book_category`
  ADD PRIMARY KEY (`book_sub`);

--
-- Indexes for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `faculty`
--

--
-- Indexes for table `faculty_borrow`
--
ALTER TABLE `faculty_borrow`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `fk_book_id` (`book_id`),
  ADD KEY `fk_faculty_id` (`id`);

--
-- Indexes for table `librarian`
--
ALTER TABLE `librarian`
  ADD PRIMARY KEY (`lib_id`);

--
-- Indexes for table `library_status`
--
ALTER TABLE `library_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `student_profile`
--

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `book_category`
--
ALTER TABLE `book_category`
  MODIFY `book_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `faculty`

--
-- AUTO_INCREMENT for table `faculty_borrow`
--
ALTER TABLE `faculty_borrow`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `librarian`
--
ALTER TABLE `librarian`
  MODIFY `lib_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `library_status`
--
ALTER TABLE `library_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_profile`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_book_sub` FOREIGN KEY (`book_sub`) REFERENCES `book_category` (`book_sub`);

--
-- Constraints for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD CONSTRAINT `borrowed_books_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `borrowed_books_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student_profilings` (`student_id`);

--
-- Constraints for table `faculty_borrow`
--
ALTER TABLE `faculty_borrow`
  ADD CONSTRAINT `fk_book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `fk_faculty_id` FOREIGN KEY (`id`) REFERENCES `faculty_profile` (`id`);

--
-- Constraints for table `library_status`
--
ALTER TABLE `library_status`
  ADD CONSTRAINT `library_status_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_profilings` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
