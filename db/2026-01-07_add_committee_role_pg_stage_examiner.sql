-- Add committee role for stage examiner

ALTER TABLE `pg_stage_examiner`
  ADD COLUMN `committee_role` TINYINT(1) NOT NULL DEFAULT 3 AFTER `stage_id`;
