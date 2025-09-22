-- Add phone column to st_student
-- Run these statements against your MySQL database.

ALTER TABLE `st_student`
  ADD COLUMN `phone` VARCHAR(20) NULL AFTER `nric`;
