-- Add status_daftar column to pg_student
-- Generated: 2025-12-17

ALTER TABLE `pg_student`
  ADD COLUMN `status_daftar` INT NULL AFTER `status`;
