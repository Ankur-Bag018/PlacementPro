

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
--
-- Database: `placementpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `job_type` enum('Full-Time','Part-Time','Internship') NOT NULL,
  `salary` varchar(50) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `requirements` text NOT NULL,
  `description` text NOT NULL,
  `deadline` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `posted_by`, `company_name`, `job_title`, `job_type`, `salary`, `location`, `requirements`, `description`, `deadline`, `created_at`) VALUES
(14, 19, 'TCS', 'Backend Developer', 'Full-Time', '35000', 'Delhi', 'Require CGPA-7.5, PHP, JAVA, C, DSA, OOPs, OS ', 'Now, when you load the page, all job cards will be neatly small. When a student clicks \"Read More\", only that specific card will smoothly grow downwards to show the full details, while all the other cards remain completely unaffected.', '2027-01-31', '2026-11-12 18:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `application_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `gmail_id` varchar(255) NOT NULL,
  `resume_file` varchar(255) NOT NULL,
  `status` enum('Pending','Selected','Rejected') DEFAULT 'Pending',
  `applied_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`application_id`, `job_id`, `gmail_id`, `resume_file`, `status`, `applied_date`) VALUES
(6, 14, 'ayan@gmail.com', 'uploads/resumes/ayan_resume_1794331867.pdf', 'Selected', '2026-11-12 23:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `id` int(11) NOT NULL,
  `college_id` varchar(50) DEFAULT NULL,
  `roll_number` varchar(50) DEFAULT NULL,
  `registration_number` varchar(50) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `gmail_id` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `section` varchar(20) DEFAULT NULL,
  `active_backlog` int(11) DEFAULT 0,
  `sgpa_1st_sem` decimal(4,2) DEFAULT NULL,
  `sgpa_2nd_sem` decimal(4,2) DEFAULT NULL,
  `sgpa_3rd_sem` decimal(4,2) DEFAULT NULL,
  `sgpa_4th_sem` decimal(4,2) DEFAULT NULL,
  `sgpa_5th_sem` decimal(4,2) DEFAULT NULL,
  `sgpa_6th_sem` decimal(4,2) DEFAULT NULL,
  `sgpa_7th_sem` decimal(4,2) DEFAULT NULL,
  `sgpa_8th_sem` decimal(4,2) DEFAULT NULL,
  `overall_cgpa` decimal(4,2) DEFAULT NULL,
  `resume_file` varchar(255) DEFAULT NULL,
  `registration_card_file` varchar(255) DEFAULT NULL,
  `all_semester_result_file` varchar(255) DEFAULT NULL,
  `aadhar_card_file` varchar(255) DEFAULT NULL,
  `college_id_card_file` varchar(255) DEFAULT NULL,
  `marksheet_10th_file` varchar(255) DEFAULT NULL,
  `marksheet_12th_file` varchar(255) DEFAULT NULL,
  `admit_card_10th_file` varchar(255) DEFAULT NULL,
  `admit_card_12th_file` varchar(255) DEFAULT NULL,
  `passport_size_photo_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_details`
--

INSERT INTO `student_details` (`id`, `college_id`, `roll_number`, `registration_number`, `department`, `academic_year`, `semester`, `gmail_id`, `date_of_birth`, `section`, `active_backlog`, `sgpa_1st_sem`, `sgpa_2nd_sem`, `sgpa_3rd_sem`, `sgpa_4th_sem`, `sgpa_5th_sem`, `sgpa_6th_sem`, `sgpa_7th_sem`, `sgpa_8th_sem`, `overall_cgpa`, `resume_file`, `registration_card_file`, `all_semester_result_file`, `aadhar_card_file`, `college_id_card_file`, `marksheet_10th_file`, `marksheet_12th_file`, `admit_card_10th_file`, `admit_card_12th_file`, `passport_size_photo_file`) VALUES
(9, '22624256', '22642724030', '242661010030', 'B.Tech IT', '4th Year', '7', 'ayan@gmail.com', '2026-11-18', 'k1', 0, 6.00, 6.00, 6.00, 6.00, 6.00, 6.00, NULL, NULL, 6.00, 'uploads/resumes/ayan_resume_1794331867.pdf', 'uploads/documents/ayan_reg_card_1794332015.pdf', 'uploads/documents/ayan_sem_results_1794332015.pdf', 'uploads/documents/ayan_aadhar_card_1794332015.pdf', 'uploads/documents/ayan_college_id_1794332015.pdf', 'uploads/documents/ayan_marksheet_10_1794332015.pdf', 'uploads/documents/ayan_marksheet_12_1794332015.pdf', 'uploads/documents/ayan_admit_10_1794332015.pdf', 'uploads/documents/ayan_admit_12_1794332015.pdf', 'uploads/documents/ayan_passport_photo_1794332015.jpeg'),
(10, '22624256', '22642724029', '242661010030', 'BCA', '1st Year', '1', 'sourin@gmail.com', '2006-07-03', 'T1', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'uploads/resumes/sourin_resume_1794507730.pdf', 'uploads/documents/sourin_reg_card_1794507730.pdf', 'uploads/documents/sourin_sem_results_1794507730.pdf', 'uploads/documents/sourin_aadhar_card_1794507730.pdf', 'uploads/documents/sourin_college_id_1794507730.pdf', 'uploads/documents/sourin_marksheet_10_1794507730.pdf', 'uploads/documents/sourin_marksheet_12_1794507730.pdf', 'uploads/documents/sourin_admit_10_1794507730.pdf', 'uploads/documents/sourin_admit_12_1794507730.pdf', 'uploads/documents/sourin_passport_photo_1794507730.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` text DEFAULT NULL,
  `role` enum('Student','Recruiter','Coordinator','Admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password_hash`, `phone_number`, `address`, `role`, `created_at`) VALUES
(11, 'Ankur Bag', 'ankurbag@gmail.com', '$2y$10$5Wap2gQu4RIRI9GYGPtxGuFIcqMgbAumO7IjCjntIu3nADLGLnF56', '7074936676', 'Sonargoria\r\nSonargoria High School', 'Admin', '2026-10-27 18:14:04'),
(19, 'Ankita', 'ankita@gmail.com', '$2y$10$Ip6ZENmVwGMvXsluJ52nkeZMpicTgtsJhX5II2SZwFgcdQfr0D0DW', '7074936676', 'Sonargoria\r\nSonargoria High School', 'Coordinator', '2026-10-30 07:38:18'),
(20, 'Atreya', 'atreya@gmail.com', '$2y$10$MRvHwaSJa2mmur125Y/LDumrM9yMyT/jJ880iPBY31A7s9VDmcMYa', '7074936676', 'Sonargoria\r\nSonargoria High School', 'Admin', '2026-10-30 07:38:54'),
(24, 'Ayan Roy', 'ayan@gmail.com', '$2y$10$FE7hV7LbZlD2MO7AOhHanef2hieJBofop2rBxYc0L1/x73F8zX/iO', '8001515017', 'Sonargoria\r\nSonargoria High School', 'Student', '2026-11-10 17:26:54'),
(25, 'Sourin', 'sourin@gmail.com', '$2y$10$Q9ipGvAYiUcTL3EZJVsGtOWdaonk1nt80EHegI9U3wSE160D9UiaG', '7797638787', '1234', 'Student', '2026-11-10 17:43:36'),
(27, 'Sayak Roy', 'sayak@gmail.com', '$2y$10$jxGSmMcmSektoIg4vW2ZBOesIX1j2Z5br7mRfM5G5qLbk3AQdlu1C', '8001515017', 'Kolkata', 'Admin', '2026-11-12 18:15:55'),
(28, 'Argha Bhukta', 'argha@gmail.com', '$2y$10$ltBTlefQSRcecs9Ny2VCIuOsmYCxZbJvGIYEfOIp34ECF9lxgVNDC', '7029336817', 'Kolkata', 'Student', '2026-11-13 17:25:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `posted_by` (`posted_by`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`application_id`),
  ADD UNIQUE KEY `unique_application` (`job_id`,`gmail_id`),
  ADD KEY `gmail_id` (`gmail_id`);

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gmail_id` (`gmail_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_details`
--
ALTER TABLE `student_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;


ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_applications_ibfk_2` FOREIGN KEY (`gmail_id`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `student_details`
  ADD CONSTRAINT `student_details_ibfk_1` FOREIGN KEY (`gmail_id`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

