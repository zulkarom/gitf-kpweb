-- Add last_status_daftar column to pg_student, drop other status, the real status daftar at student registration table
-- Generated: 2026-01-07

ALTER TABLE `pg_student`
  ADD COLUMN `last_status_daftar` INT NULL AFTER `status`;
