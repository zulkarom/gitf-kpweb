-- Add status_aktif column to pg_student
-- Generated: 2025-12-17

ALTER TABLE `pg_student`
  ADD COLUMN `status_aktif` TINYINT NULL AFTER `status_daftar`;
