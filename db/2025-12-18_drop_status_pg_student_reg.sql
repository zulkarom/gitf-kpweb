-- Drop status column from pg_student_reg
-- Run ONLY after all code has been updated to no longer reference pg_student_reg.status.

ALTER TABLE `pg_student_reg`
  DROP COLUMN `status`;
