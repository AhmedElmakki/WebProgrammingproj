-- Create the database
CREATE DATABASE IF NOT EXISTS students_db;

-- Use the created database
USE students_db;

-- Create the `students` table
CREATE TABLE `students` (
  `name` varchar(100) NOT NULL,
  `role` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add primary key to `students` table
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

-- Create the `users` table
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add primary and unique keys to `users` table
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

-- Enable AUTO_INCREMENT for `users` table
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
