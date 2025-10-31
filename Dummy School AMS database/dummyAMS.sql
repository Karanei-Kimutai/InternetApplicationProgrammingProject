-- Create the new database.
CREATE DATABASE university_external_db;

-- Switch to the new database.
USE university_external_db;

--
-- Table structure for table `students`
--
CREATE TABLE `students` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--
INSERT INTO `students` (`id`, `name`, `email`, `password`, `photo_url`) VALUES
(183523, 'Karanei Kimutai', 'kimutai.karanei@strathmore.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/women/1.jpg'),
(190004, 'Witness Mukundi', 'mukundi.chingwena@strathmore.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/men/2.jpg'),
(130103, 'Fatima Yusuf', 'fatima.yusuf@university.ac.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/women/3.jpg'),
(130104, 'David Kariuki', 'david.kariuki@university.ac.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/men/4.jpg'),
(130105, 'Chloe Wangari', 'chloe.wangari@university.ac.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/women/5.jpg'),
(130106, 'Samuel Mwangi', 'samuel.mwangi@university.ac.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/men/6.jpg');

--
-- Table structure for table `lecturers`
--
CREATE TABLE `lecturers` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturers`
--
INSERT INTO `lecturers` (`id`, `name`, `email`, `password`, `photo_url`) VALUES
(2101, 'Dr. Eleanor Wanjiku', 'eleanor.wanjiku@university.ac.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/women/10.jpg'),
(2102, 'Prof. Ken Ochieng', 'ken.ochieng@university.ac.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/men/11.jpg'),
(2103, 'Dr. Imani Nassir', 'imani.nassir@university.ac.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/women/12.jpg'),
(2104, 'Prof. Mark Chepkwony', 'mark.chepkwony@university.ac.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/men/14.jpg'),
(2105, 'Dr. Amina Hussein', 'amina.hussein@university.ac.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/women/15.jpg'),
(2106, 'Prof. Victor Mutai', 'victor.mutai@university.ac.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://randomuser.me/api/portraits/men/16.jpg');

--
-- Structure for VIEW `v_university_members`
--
CREATE VIEW `v_university_members` AS
SELECT
  `id`,
  `name`,
  `email`,
  `password`,
  `photo_url`,
  'student' AS `role`
FROM `students`
UNION ALL
SELECT
  `id`,
  `name`,
  `email`,
  `password`,
  `photo_url`,
  'lecturer' AS `role`
FROM `lecturers`;

COMMIT;

