-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2025 at 02:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_tb`
--

CREATE TABLE `course_tb` (
  `course_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `course_image` varchar(255) NOT NULL,
  `status` enum('publish','unpublish') NOT NULL DEFAULT 'unpublish',
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_completion_tb`
--

CREATE TABLE `lesson_completion_tb` (
  `lc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_image_tb`
--

CREATE TABLE `lesson_image_tb` (
  `image_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_tb`
--

CREATE TABLE `lesson_tb` (
  `lesson_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `status` enum('complete','progress') NOT NULL DEFAULT 'progress',
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_video_tb`
--

CREATE TABLE `lesson_video_tb` (
  `video_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `video_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_completion_tb`
--

CREATE TABLE `module_completion_tb` (
  `mc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `date_passed` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_tb`
--

CREATE TABLE `module_tb` (
  `module_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otp_switch_tb`
--

CREATE TABLE `otp_switch_tb` (
  `switch_id` int(11) NOT NULL,
  `with_otp` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otp_switch_tb`
--

INSERT INTO `otp_switch_tb` (`switch_id`, `with_otp`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `otp_tb`
--

CREATE TABLE `otp_tb` (
  `otp_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp_code` int(5) NOT NULL,
  `purpose` enum('login','reset password') NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otp_tb`
--

INSERT INTO `otp_tb` (`otp_id`, `user_id`, `otp_code`, `purpose`, `expires_at`, `created_at`) VALUES
(87, 24, 36608, 'login', '2025-04-27 18:23:02', '2025-04-27 10:18:02'),
(88, 24, 30306, 'login', '2025-04-27 23:51:41', '2025-04-27 15:46:41'),
(92, 24, 48858, 'login', '2025-04-28 08:38:48', '2025-04-28 00:33:48'),
(93, 24, 30752, 'login', '2025-04-28 15:20:29', '2025-04-28 07:15:29'),
(94, 24, 71598, 'login', '2025-04-28 15:28:56', '2025-04-28 07:23:56'),
(96, 24, 28422, 'login', '2025-04-28 16:38:01', '2025-04-28 08:33:01'),
(98, 24, 78642, 'login', '2025-04-28 18:30:52', '2025-04-28 10:25:52'),
(100, 24, 83374, 'login', '2025-04-29 07:11:57', '2025-04-28 23:06:57'),
(103, 24, 74280, 'login', '2025-04-29 08:26:06', '2025-04-29 00:21:06'),
(105, 24, 53258, 'login', '2025-04-29 09:21:20', '2025-04-29 01:16:20'),
(106, 24, 97475, 'login', '2025-04-29 15:21:56', '2025-04-29 07:16:56'),
(108, 24, 53250, 'login', '2025-04-29 21:01:12', '2025-04-29 12:56:12'),
(110, 24, 66578, 'login', '2025-04-30 07:07:51', '2025-04-29 23:02:51'),
(112, 24, 58416, 'login', '2025-04-30 07:34:44', '2025-04-29 23:29:44'),
(114, 24, 67753, 'login', '2025-04-30 11:45:40', '2025-04-30 03:40:40'),
(116, 24, 76012, 'login', '2025-04-30 19:26:02', '2025-04-30 11:21:02'),
(118, 24, 25739, 'login', '2025-05-01 11:07:33', '2025-05-01 03:02:33'),
(120, 24, 15943, 'login', '2025-05-02 08:29:02', '2025-05-02 00:24:02'),
(122, 24, 78550, 'login', '2025-05-02 18:07:36', '2025-05-02 10:02:36'),
(130, 24, 62996, 'login', '2025-05-04 05:36:51', '2025-05-03 21:31:51'),
(131, 24, 12472, 'login', '2025-05-05 15:17:25', '2025-05-05 07:12:25'),
(132, 24, 53667, 'login', '2025-05-05 22:23:09', '2025-05-05 14:18:09'),
(133, 24, 68816, 'login', '2025-10-03 08:48:28', '2025-10-03 00:43:28');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_answer_key_tb`
--

CREATE TABLE `quiz_answer_key_tb` (
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `correct` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question_tb`
--

CREATE TABLE `quiz_question_tb` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `type` enum('radio','checkbox') NOT NULL DEFAULT 'radio',
  `choice_a` text NOT NULL,
  `choice_b` text NOT NULL,
  `choice_c` text NOT NULL,
  `choice_d` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_result_tb`
--

CREATE TABLE `quiz_result_tb` (
  `result_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `correct_answers` int(11) NOT NULL,
  `score_percentage` decimal(5,2) NOT NULL,
  `attempts` int(11) NOT NULL,
  `date_taken` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_tb`
--

CREATE TABLE `quiz_tb` (
  `quiz_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `passing_score` decimal(5,2) NOT NULL DEFAULT 70.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_course_tb`
--

CREATE TABLE `student_course_tb` (
  `sc_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `finish` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('enrolled','withdrawn') NOT NULL DEFAULT 'enrolled',
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE `user_tb` (
  `user_Id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` enum('teacher','student') NOT NULL DEFAULT 'student',
  `picture` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tb`
--

INSERT INTO `user_tb` (`user_Id`, `name`, `email`, `password`, `role`, `picture`, `updated_at`, `created_at`) VALUES
(24, 'Admin', 'kitchenomachiaacademy@gmail.com', '$2y$10$vtdnPZ/oH9Bq1v/YjV9PNON3yJMQAZ7umlYfB.d78XNrB.9SJ5X2S', 'teacher', 'data/teacher/profile/logo-w-bg.png', '2025-04-29 07:30:24', '2025-04-27 10:16:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_tb`
--
ALTER TABLE `course_tb`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `fk_course_user_id` (`teacher_id`);

--
-- Indexes for table `lesson_completion_tb`
--
ALTER TABLE `lesson_completion_tb`
  ADD PRIMARY KEY (`lc_id`),
  ADD KEY `fk_lesson_id` (`lesson_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `lesson_image_tb`
--
ALTER TABLE `lesson_image_tb`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `fk_lesson_image_id` (`lesson_id`);

--
-- Indexes for table `lesson_tb`
--
ALTER TABLE `lesson_tb`
  ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `fk_lesson_module_id` (`module_id`);

--
-- Indexes for table `lesson_video_tb`
--
ALTER TABLE `lesson_video_tb`
  ADD PRIMARY KEY (`video_id`),
  ADD KEY `fk_lesson_video_id` (`lesson_id`);

--
-- Indexes for table `module_completion_tb`
--
ALTER TABLE `module_completion_tb`
  ADD PRIMARY KEY (`mc_id`),
  ADD KEY `fk_mc_user_id` (`user_id`),
  ADD KEY `fk_mc_module_id` (`module_id`);

--
-- Indexes for table `module_tb`
--
ALTER TABLE `module_tb`
  ADD PRIMARY KEY (`module_id`),
  ADD KEY `fk_module_course_id` (`course_id`);

--
-- Indexes for table `otp_switch_tb`
--
ALTER TABLE `otp_switch_tb`
  ADD PRIMARY KEY (`switch_id`);

--
-- Indexes for table `otp_tb`
--
ALTER TABLE `otp_tb`
  ADD PRIMARY KEY (`otp_id`),
  ADD KEY `fk_otp_user` (`user_id`);

--
-- Indexes for table `quiz_answer_key_tb`
--
ALTER TABLE `quiz_answer_key_tb`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `fk_question_id` (`question_id`);

--
-- Indexes for table `quiz_question_tb`
--
ALTER TABLE `quiz_question_tb`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `fk_quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_result_tb`
--
ALTER TABLE `quiz_result_tb`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `fk_result_module_id` (`module_id`),
  ADD KEY `fk_result_user_id` (`user_id`);

--
-- Indexes for table `quiz_tb`
--
ALTER TABLE `quiz_tb`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `fk_module_id` (`module_id`);

--
-- Indexes for table `student_course_tb`
--
ALTER TABLE `student_course_tb`
  ADD PRIMARY KEY (`sc_id`),
  ADD KEY `fk_student_id` (`student_id`),
  ADD KEY `fk_course_id` (`course_id`);

--
-- Indexes for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD PRIMARY KEY (`user_Id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_tb`
--
ALTER TABLE `course_tb`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `lesson_completion_tb`
--
ALTER TABLE `lesson_completion_tb`
  MODIFY `lc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `lesson_image_tb`
--
ALTER TABLE `lesson_image_tb`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `lesson_tb`
--
ALTER TABLE `lesson_tb`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `lesson_video_tb`
--
ALTER TABLE `lesson_video_tb`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `module_completion_tb`
--
ALTER TABLE `module_completion_tb`
  MODIFY `mc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `module_tb`
--
ALTER TABLE `module_tb`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `otp_switch_tb`
--
ALTER TABLE `otp_switch_tb`
  MODIFY `switch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `otp_tb`
--
ALTER TABLE `otp_tb`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `quiz_answer_key_tb`
--
ALTER TABLE `quiz_answer_key_tb`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `quiz_question_tb`
--
ALTER TABLE `quiz_question_tb`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `quiz_result_tb`
--
ALTER TABLE `quiz_result_tb`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `quiz_tb`
--
ALTER TABLE `quiz_tb`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `student_course_tb`
--
ALTER TABLE `student_course_tb`
  MODIFY `sc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `user_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_tb`
--
ALTER TABLE `course_tb`
  ADD CONSTRAINT `fk_course_user_id` FOREIGN KEY (`teacher_id`) REFERENCES `user_tb` (`user_Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lesson_completion_tb`
--
ALTER TABLE `lesson_completion_tb`
  ADD CONSTRAINT `fk_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lesson_tb` (`lesson_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_tb` (`user_Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lesson_image_tb`
--
ALTER TABLE `lesson_image_tb`
  ADD CONSTRAINT `fk_lesson_image_id` FOREIGN KEY (`lesson_id`) REFERENCES `lesson_tb` (`lesson_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lesson_tb`
--
ALTER TABLE `lesson_tb`
  ADD CONSTRAINT `fk_lesson_module_id` FOREIGN KEY (`module_id`) REFERENCES `module_tb` (`module_id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_video_tb`
--
ALTER TABLE `lesson_video_tb`
  ADD CONSTRAINT `fk_lesson_video_id` FOREIGN KEY (`lesson_id`) REFERENCES `lesson_tb` (`lesson_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `module_completion_tb`
--
ALTER TABLE `module_completion_tb`
  ADD CONSTRAINT `fk_mc_module_id` FOREIGN KEY (`module_id`) REFERENCES `module_tb` (`module_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mc_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_tb` (`user_Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `module_tb`
--
ALTER TABLE `module_tb`
  ADD CONSTRAINT `fk_module_course_id` FOREIGN KEY (`course_id`) REFERENCES `course_tb` (`course_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `otp_tb`
--
ALTER TABLE `otp_tb`
  ADD CONSTRAINT `fk_otp_user` FOREIGN KEY (`user_id`) REFERENCES `user_tb` (`user_Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `quiz_answer_key_tb`
--
ALTER TABLE `quiz_answer_key_tb`
  ADD CONSTRAINT `fk_question_id` FOREIGN KEY (`question_id`) REFERENCES `quiz_question_tb` (`question_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `quiz_question_tb`
--
ALTER TABLE `quiz_question_tb`
  ADD CONSTRAINT `fk_quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz_tb` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_result_tb`
--
ALTER TABLE `quiz_result_tb`
  ADD CONSTRAINT `fk_result_module_id` FOREIGN KEY (`module_id`) REFERENCES `module_tb` (`module_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_result_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_tb` (`user_Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `quiz_tb`
--
ALTER TABLE `quiz_tb`
  ADD CONSTRAINT `fk_module_id` FOREIGN KEY (`module_id`) REFERENCES `module_tb` (`module_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `student_course_tb`
--
ALTER TABLE `student_course_tb`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`course_id`) REFERENCES `course_tb` (`course_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `user_tb` (`user_Id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
