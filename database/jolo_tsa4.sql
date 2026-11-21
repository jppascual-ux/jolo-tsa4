-- =====================================================================
--  Tasks for Today Management System (Laravel) - database export
--  IT0049 Web System Technologies, TSA 4
--
--  Same tables the migrations create, plus the seeder's data.
--  Use this where artisan cannot run (e.g. free hosting):
--    phpMyAdmin > select your database > Import > choose this file > Import
--
--  Importing replaces the users, tasks and migrations tables.
--
--  Demo login:  juan.delacruz@example.com  /  demo1234
--  (the password is stored as a bcrypt hash)
--  Task dates use CURDATE(), so "today" always has tasks on the day you
--  import. Re-import on submission day to refresh the dates.
-- =====================================================================

SET NAMES utf8mb4;
SET time_zone = '+08:00';  -- Asia/Manila, matches config/app.php

DROP TABLE IF EXISTS `tasks`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `task_date` date NOT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('2026_11_21_000001_create_tasks_table', 1),
('2026_11_21_000002_add_is_archived_to_tasks_table', 1),
('2026_11_21_000003_add_password_to_users_table', 1);

-- Exactly one user (password: demo1234)
INSERT INTO `users` (`username`, `full_name`, `email`, `password`, `created_at`, `updated_at`) VALUES
('jdelacruz', 'Juan Dela Cruz', 'juan.delacruz@example.com', '$2y$12$2xJj8vGb5zDCYdlYtun4zOzKDoJ1w.imu0dQ5l64c2QeoujHMoJvK', NOW(), NOW());

-- 10 tasks across 4 dates (yesterday, today, tomorrow, +3 days)
INSERT INTO `tasks` (`title`, `status`, `task_date`, `is_archived`, `created_at`, `updated_at`) VALUES
('Draft weekly content calendar',                 'done',        CURDATE() - INTERVAL 1 DAY,  0, NOW(), NOW()),
('Review partner brief for the October campaign', 'done',        CURDATE() - INTERVAL 1 DAY,  0, NOW(), NOW()),
('Back up the shared project drive',              'pending',     CURDATE() - INTERVAL 1 DAY,  0, NOW(), NOW()),
('Stand-up meeting with the web team',            'done',        CURDATE(),                   0, NOW(), NOW()),
('Fix broken links on the landing page',          'in-progress', CURDATE(),                   0, NOW(), NOW()),
('Update brand colors in the style guide',        'pending',     CURDATE(),                   0, NOW(), NOW()),
('Send status report to the project lead',        'pending',     CURDATE(),                   0, NOW(), NOW()),
('Prepare client presentation slides',            'pending',     CURDATE() + INTERVAL 1 DAY,  0, NOW(), NOW()),
('Test the contact form on mobile browsers',      'pending',     CURDATE() + INTERVAL 1 DAY,  0, NOW(), NOW()),
('Deploy the September release to hosting',       'pending',     CURDATE() + INTERVAL 3 DAY,  0, NOW(), NOW());
