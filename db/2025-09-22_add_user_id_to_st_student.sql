-- Add user_id column to st_student, create index, and add foreign key to user(id)
-- Run these statements against your MySQL database.

ALTER TABLE `st_student`
  ADD COLUMN `user_id` INT NULL AFTER `program`;

CREATE INDEX `idx-st_student-user_id`
  ON `st_student` (`user_id`);

ALTER TABLE `st_student`
  ADD CONSTRAINT `fk-st_student-user_id`
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;
