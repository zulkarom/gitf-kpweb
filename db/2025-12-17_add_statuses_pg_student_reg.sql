ALTER TABLE `pg_student_reg`
  ADD COLUMN `status_daftar` TINYINT NULL AFTER `status`,
  ADD COLUMN `status_aktif` TINYINT NULL AFTER `status_daftar`;

CREATE UNIQUE INDEX `ux_pg_student_reg_student_semester`
  ON `pg_student_reg` (`student_id`, `semester_id`);
