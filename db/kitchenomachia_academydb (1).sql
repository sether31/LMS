-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 04:59 PM
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
-- Database: `kitchenomachia_academydb`
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

--
-- Dumping data for table `course_tb`
--

INSERT INTO `course_tb` (`course_id`, `teacher_id`, `title`, `description`, `course_image`, `status`, `is_delete`, `updated_at`, `created_at`) VALUES
(55, 24, 'Fundamentals of Cooking: Techniques, Tools, and Preparation', 'Master the core techniques and tools every home cook must know. This course covers knife safety, proper ingredient preparation, essential cooking methods, and kitchen organization for beginners and intermediate learners alike.', 'data/teacher/course/course-image/chinh-le-duc-vuDXJ60mJOA-unsplash.jpg', 'publish', 0, '2025-05-05 04:40:39', '2025-04-30 02:02:47'),
(58, 24, 'Laumpiang Shanghi', '\r\n Learn how to make Lumpiang Shanghai — Filipino-style meat spring rolls that are crispy, savory, and always a crowd favorite. Perfect for parties and celebrations!', 'data/teacher/course/course-image/96cf549d8b866ca5b337bd6ffde11d01.jpg', 'unpublish', 0, '2025-05-05 14:35:36', '2025-05-05 14:35:36');

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

--
-- Dumping data for table `lesson_completion_tb`
--

INSERT INTO `lesson_completion_tb` (`lc_id`, `user_id`, `lesson_id`, `completed_at`) VALUES
(32, 25, 127, '2025-05-04 00:39:12'),
(40, 26, 127, '2025-05-05 06:36:20');

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

--
-- Dumping data for table `lesson_tb`
--

INSERT INTO `lesson_tb` (`lesson_id`, `module_id`, `title`, `content`, `status`, `is_delete`, `updated_at`, `created_at`) VALUES
(127, 75, 'Step-by-Step Fundamentals of Cooking', 'Step 1: Understanding Kitchen Safety\r\n\r\n  1. Always keep knives sharp — dull knives are more dangerous.\r\n  2. Clean as you go to prevent clutter and accidents.\r\n  3. Use a dry towel under your cutting board to prevent \r\n  slipping.\r\n  4. Never leave cooking food unattended on the stove.\r\n  5. Know where the fire extinguisher is and how to use it.\r\n\r\n\r\nStep 2: Proper Knife Handling and Cutting Techniques\r\n\r\n  1. Use the correct knife (chef’s knife for chopping, paring knife for peeling, etc.).\r\n  2. Grip the knife with your dominant hand; pinch the blade between your thumb and index finger for control.\r\n  3. Curl your non-dominant hand into a claw shape to guide the food safely.\r\n  4. Start with soft ingredients like onions or tomatoes for practice.\r\n  5. Start with soft ingredients like onions or tomatoes for practice.\r\n\r\n\r\nStep 3: How to Boil Water and Cook Pasta\r\n\r\n  1. Fill a pot with cold water (about 3/4 full).\r\n  2. Place the pot on a stovetop burner and set to high heat..\r\n  3. Add a pinch of salt to flavor the water\r\n  4. Once the water is at a rolling boil, add pasta or vegetables.\r\n  5. Stir occasionally to prevent sticking.\r\n  6. Cook until soft but slightly firm (al dente), then drain immediately.\r\n\r\n\r\nStep 4: How to Sauté Vegetables\r\n\r\n  1. Heat a tablespoon of oil in a pan over medium heat.\r\n  2. Add aromatic ingredients like garlic or onion first.\r\n  3. Stir with a wooden spoon until fragrant and translucent.\r\n  4. Add your main vegetables (e.g., carrots, bell peppers).\r\n  5. Stir constantly for even cooking — usually 3–7 minutes depending on thickness.\r\n  6. Season with salt and pepper before removing from heat.\r\n\r\n\r\nStep 5: Simmering vs. Boiling\r\n\r\n  1. Boiling involves large, rolling bubbles (100°C); ideal for pasta or hard vegetables.\r\n  2. Simmering is gentler, with small bubbles (85–95°C); perfect for soups and stews.\r\n  3. Use a thermometer or visual cues to identify the difference.\r\n  4. To reduce to a simmer, lower the heat after boiling and observe smaller bubbles.\r\n  5. Keep the pot partially covered to avoid evaporation.\r\n\r\n\r\nStep 6: Cooking with Proper Heat Control\r\n\r\n  1. Low heat is good for melting and slow cooking.\r\n  2. Medium heat is used for sautéing and pan-frying\r\n  3. High heat is for boiling and searing meats.\r\n  4. Always preheat your pan before adding ingredients\r\n  5. Avoid overcrowding pans — it cools them down and causes soggy food.\r\n\r\n\r\nStep 7: Seasoning and Tasting\r\n\r\n  1. Taste your food often while cooking\r\n  2. Add salt gradually — you can always add more but not remove it.\r\n  3. Use herbs and spices sparingly at first, especially strong ones like chili or cumin.\r\n  4. Balance flavors: sweet (sugar), sour (vinegar), salty (soy sauce), umami (oyster sauce).\r\n  5. Adjust at the end based on taste.\r\n\r\n\r\nStep 8: Cleaning and Storing\r\n\r\n  1. Let pans cool before washing\r\n  2. Wash knives separately to avoid injury.\r\n  3. Store leftovers in airtight containers within 2 hours of cooking\r\n  4. Label containers with dates.\r\n  5. Clean your kitchen tools after each use to avoid cross-contamination.', 'progress', 0, '2025-04-30 11:22:45', '2025-04-30 02:06:29');

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

--
-- Dumping data for table `module_completion_tb`
--

INSERT INTO `module_completion_tb` (`mc_id`, `user_id`, `module_id`, `date_passed`) VALUES
(5, 25, 75, '2025-05-04 00:40:15'),
(10, 26, 75, '2025-05-05 06:37:30');

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

--
-- Dumping data for table `module_tb`
--

INSERT INTO `module_tb` (`module_id`, `course_id`, `title`, `description`, `status`, `is_delete`, `updated_at`, `created_at`) VALUES
(75, 55, 'Mastering Basic Cooking Skills', 'Learn foundational techniques such as boiling, sautéing, simmering, and knife handling. Understand heat control, cooking terms, and how to prepare ingredients correctly. Ideal for anyone starting their cooking journey.', 'active', 0, '2025-04-30 04:04:25', '2025-04-30 02:03:53'),
(83, 58, 'Rolling and Frying Lumpiang Shanghai', 'This asdasdasd yo\'ll', 'inactive', 0, '2025-05-05 14:51:51', '2025-05-05 14:38:48'),
(84, 58, '123', '123', 'inactive', 0, '2025-05-05 14:38:48', '2025-05-05 14:38:48');

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
(1, 1);

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
(89, 25, 38264, 'login', '2025-04-28 08:34:29', '2025-04-28 00:29:29'),
(90, 25, 34882, 'reset password', '2025-04-28 08:35:08', '2025-04-28 00:30:08'),
(91, 25, 61435, 'login', '2025-04-28 08:37:30', '2025-04-28 00:32:30'),
(92, 24, 48858, 'login', '2025-04-28 08:38:48', '2025-04-28 00:33:48'),
(93, 24, 30752, 'login', '2025-04-28 15:20:29', '2025-04-28 07:15:29'),
(94, 24, 71598, 'login', '2025-04-28 15:28:56', '2025-04-28 07:23:56'),
(95, 26, 21415, 'login', '2025-04-28 15:51:00', '2025-04-28 07:46:00'),
(96, 24, 28422, 'login', '2025-04-28 16:38:01', '2025-04-28 08:33:01'),
(97, 26, 33763, 'login', '2025-04-28 18:12:57', '2025-04-28 10:07:57'),
(98, 24, 78642, 'login', '2025-04-28 18:30:52', '2025-04-28 10:25:52'),
(99, 25, 15882, 'login', '2025-04-29 06:58:19', '2025-04-28 22:53:19'),
(100, 24, 83374, 'login', '2025-04-29 07:11:57', '2025-04-28 23:06:57'),
(101, 25, 40712, 'login', '2025-04-29 07:50:10', '2025-04-28 23:45:10'),
(102, 25, 59990, 'login', '2025-04-29 07:53:19', '2025-04-28 23:48:19'),
(103, 24, 74280, 'login', '2025-04-29 08:26:06', '2025-04-29 00:21:06'),
(104, 25, 56021, 'login', '2025-04-29 09:14:13', '2025-04-29 01:09:13'),
(105, 24, 53258, 'login', '2025-04-29 09:21:20', '2025-04-29 01:16:20'),
(106, 24, 97475, 'login', '2025-04-29 15:21:56', '2025-04-29 07:16:56'),
(107, 25, 57192, 'login', '2025-04-29 15:21:57', '2025-04-29 07:16:57'),
(108, 24, 53250, 'login', '2025-04-29 21:01:12', '2025-04-29 12:56:12'),
(109, 25, 35037, 'login', '2025-04-30 07:06:06', '2025-04-29 23:01:07'),
(110, 24, 66578, 'login', '2025-04-30 07:07:51', '2025-04-29 23:02:51'),
(111, 25, 40592, 'login', '2025-04-30 07:32:36', '2025-04-29 23:27:36'),
(112, 24, 58416, 'login', '2025-04-30 07:34:44', '2025-04-29 23:29:44'),
(113, 25, 80803, 'login', '2025-04-30 11:43:39', '2025-04-30 03:38:39'),
(114, 24, 67753, 'login', '2025-04-30 11:45:40', '2025-04-30 03:40:40'),
(115, 25, 17116, 'login', '2025-04-30 19:10:15', '2025-04-30 11:05:15'),
(116, 24, 76012, 'login', '2025-04-30 19:26:02', '2025-04-30 11:21:02'),
(117, 25, 48749, 'login', '2025-05-01 08:06:01', '2025-05-01 00:01:01'),
(118, 24, 25739, 'login', '2025-05-01 11:07:33', '2025-05-01 03:02:33'),
(119, 25, 82973, 'login', '2025-05-02 08:09:23', '2025-05-02 00:04:23'),
(120, 24, 15943, 'login', '2025-05-02 08:29:02', '2025-05-02 00:24:02'),
(121, 25, 43098, 'login', '2025-05-02 18:05:33', '2025-05-02 10:00:33'),
(122, 24, 78550, 'login', '2025-05-02 18:07:36', '2025-05-02 10:02:36'),
(123, 25, 80161, 'login', '2025-05-03 01:56:52', '2025-05-02 17:51:52'),
(124, 25, 99913, 'login', '2025-05-03 01:57:10', '2025-05-02 17:52:10'),
(125, 25, 33150, 'login', '2025-05-03 10:27:42', '2025-05-03 02:22:42'),
(126, 25, 74747, 'login', '2025-05-03 10:34:45', '2025-05-03 02:29:45'),
(127, 25, 45973, 'login', '2025-05-03 10:34:55', '2025-05-03 02:29:55'),
(128, 25, 77167, 'login', '2025-05-03 10:39:13', '2025-05-03 02:34:13'),
(129, 25, 31049, 'login', '2025-05-03 10:42:41', '2025-05-03 02:37:41'),
(130, 24, 62996, 'login', '2025-05-04 05:36:51', '2025-05-03 21:31:51'),
(131, 24, 12472, 'login', '2025-05-05 15:17:25', '2025-05-05 07:12:25'),
(132, 24, 53667, 'login', '2025-05-05 22:23:09', '2025-05-05 14:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_answer_key_tb`
--

CREATE TABLE `quiz_answer_key_tb` (
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `correct` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_answer_key_tb`
--

INSERT INTO `quiz_answer_key_tb` (`answer_id`, `question_id`, `correct`) VALUES
(114, 91, 'a'),
(115, 92, 'b'),
(116, 93, 'c'),
(117, 94, 'b'),
(118, 95, 'b'),
(119, 96, 'b'),
(120, 97, 'a'),
(121, 98, 'a'),
(122, 99, 'a'),
(123, 100, 'a'),
(124, 101, 'a'),
(125, 102, 'a'),
(126, 103, 'a'),
(127, 104, 'a'),
(128, 105, 'a'),
(129, 105, 'b');

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

--
-- Dumping data for table `quiz_question_tb`
--

INSERT INTO `quiz_question_tb` (`question_id`, `quiz_id`, `question_text`, `type`, `choice_a`, `choice_b`, `choice_c`, `choice_d`) VALUES
(91, 22, 'What is the safest way to stabilize a cutting board?', 'radio', 'Use glue', 'Place on the edge of the counter', 'Put a damp towel underneath', 'Hold it with your foot'),
(92, 22, 'Which part of your hand should guide the knife while chopping?', 'radio', ' Fingertips', ' Palm', 'Claw-shaped fingers', 'Back of your hand'),
(93, 22, 'What does \"sauté\" mean?', 'radio', 'To bake food in a covered dish', 'To fry quickly in a small amount of oil', ' To boil until soft', ' To grill with sauce'),
(94, 22, ' How do you know water is boiling?', 'radio', ' It steams lightly', 'It has big rolling bubbles', ' It looks still', ' It changes color'),
(95, 22, 'What is the correct heat setting for sautéing?', 'radio', 'Low', 'Medium', ' High', 'Off'),
(96, 22, 'What happens when a pan is overcrowded?', 'radio', 'Food cooks faster', 'Nothing changes', 'The heat drops and food gets soggy', ' The food burns instantly'),
(97, 22, 'What’s the first ingredient usually added when sautéing?', 'radio', 'Sugar', 'Garlic/onions', 'Meat', 'Vegetables'),
(98, 22, 'Why should salt be added gradually?', 'radio', 'To reduce flavor', 'For safety', 'You can’t remove it once it’s added', 'It makes food red'),
(99, 22, 'What does \"simmer\" look like?', 'radio', 'Rolling, fast bubbles', ' No bubbles at all', 'Small, gentle bubbles', 'Bubbles jumping out of the pot'),
(100, 22, 'What cooking method is best for stews?', 'radio', 'Grilling', 'Steaming', 'Simmering', 'Sautéing'),
(101, 22, 'Which utensil is safest for stirring hot food?', 'radio', '.Metal fork ', 'Plastic spoon', 'Wooden spoon', 'Hand'),
(102, 22, ' What should you do before putting away leftovers?', 'radio', 'Eat them all', 'Let them cool and store within 2 hours', 'Leave them uncovered overnight', ' Freeze immediately'),
(103, 22, ' Which of the following is an example of proper kitchen safety?', 'radio', 'Leaving oil on the stove alone', ' Washing knives with other utensils', 'Using dry towel under cutting board', 'Heating plastic on high flame'),
(104, 22, 'What does “clean as you go” mean?', 'radio', 'Wash after every bite', 'Tidy up after the meal', 'Keep cleaning your space while cooking', 'Only clean when there’s smoke'),
(105, 22, 'Why should you taste food while cooking?', 'checkbox', 'It’s a tradition', 'To balance and adjust seasoning', 'To use more salt', ' To waste ingredients');

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

--
-- Dumping data for table `quiz_result_tb`
--

INSERT INTO `quiz_result_tb` (`result_id`, `user_id`, `module_id`, `total_questions`, `correct_answers`, `score_percentage`, `attempts`, `date_taken`) VALUES
(11, 25, 75, 15, 12, 80.00, 1, '2025-05-04 00:40:14'),
(16, 26, 75, 15, 12, 80.00, 1, '2025-05-05 06:37:30');

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

--
-- Dumping data for table `quiz_tb`
--

INSERT INTO `quiz_tb` (`quiz_id`, `module_id`, `title`, `passing_score`, `created_at`) VALUES
(22, 75, 'QUIZ: Fundamentals of Cooking', 75.00, '2025-04-30 02:42:15');

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

--
-- Dumping data for table `student_course_tb`
--

INSERT INTO `student_course_tb` (`sc_id`, `student_id`, `course_id`, `finish`, `status`, `enrolled_at`) VALUES
(17, 25, 55, 0, 'enrolled', '2025-05-04 12:08:09'),
(20, 27, 55, 0, 'enrolled', '2025-05-03 23:39:59'),
(21, 26, 55, 0, 'enrolled', '2025-05-05 06:06:33');

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
(24, 'Admin', 'kitchenomachiaacademy@gmail.com', '$2y$10$vtdnPZ/oH9Bq1v/YjV9PNON3yJMQAZ7umlYfB.d78XNrB.9SJ5X2S', 'teacher', 'data/teacher/profile/logo-w-bg.png', '2025-04-29 07:30:24', '2025-04-27 10:16:50'),
(25, 'Seth Hernandez', 'sethmichaelhernandez@gmail.com', '$2y$10$2OsS4TXyqfw6.RSpOZtRJOWs.1g0uJ1qwLoyEkY2.yERympWDt54a', 'student', 'data/student/profile/𝑭𝒓𝒐𝒈🐸✨.jpg', '2025-04-29 01:15:58', '2025-04-27 12:09:09'),
(26, 'Rainier Catinza', 'ctnz.nier.pnflrd@gmail.com', '$2y$10$.FPPvjirNz2KVhWIWCjmwOgbSGIu30/KkoXCBwT9PQVIDqgxrmRtC', 'student', NULL, '2025-04-28 07:45:33', '2025-04-28 07:45:33'),
(27, '123123', 'a@a', '$2y$10$ZyVOeUViJAqrAwVOncyW6u9CMv/X9Mw.O6qLD.uL424oOv27qchfK', 'student', NULL, '2025-05-03 22:12:19', '2025-05-03 22:12:19');

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
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `lesson_completion_tb`
--
ALTER TABLE `lesson_completion_tb`
  MODIFY `lc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `lesson_image_tb`
--
ALTER TABLE `lesson_image_tb`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `lesson_tb`
--
ALTER TABLE `lesson_tb`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `lesson_video_tb`
--
ALTER TABLE `lesson_video_tb`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `module_completion_tb`
--
ALTER TABLE `module_completion_tb`
  MODIFY `mc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `module_tb`
--
ALTER TABLE `module_tb`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `otp_switch_tb`
--
ALTER TABLE `otp_switch_tb`
  MODIFY `switch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `otp_tb`
--
ALTER TABLE `otp_tb`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `quiz_answer_key_tb`
--
ALTER TABLE `quiz_answer_key_tb`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `quiz_question_tb`
--
ALTER TABLE `quiz_question_tb`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `quiz_result_tb`
--
ALTER TABLE `quiz_result_tb`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `quiz_tb`
--
ALTER TABLE `quiz_tb`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `student_course_tb`
--
ALTER TABLE `student_course_tb`
  MODIFY `sc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `user_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
