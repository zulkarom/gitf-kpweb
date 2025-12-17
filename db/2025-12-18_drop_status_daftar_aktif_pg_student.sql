-- Drop status_daftar and status_aktif columns from pg_student
-- Run ONLY after all code has been updated to no longer reference pg_student.status_daftar/status_aktif.

ALTER TABLE `pg_student`
  DROP COLUMN `status_daftar`,
  DROP COLUMN `status_aktif`;
