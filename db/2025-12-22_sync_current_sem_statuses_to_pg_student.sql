ALTER TABLE `pg_student`
  ADD COLUMN `status_daftar` TINYINT NULL AFTER `status`,
  ADD COLUMN `status_aktif`  TINYINT NULL AFTER `status_daftar`;
