INSERT INTO pg_field (field_name) VALUES
('Ekonomi'),
('Ekonomi Islam'),
('Matematik'),
('Pengurusan Operasi'),
('Pengurusan Perdagangan'),
('Pengurusan Teknologi Dan Sistem Maklumat'),
('Perakaunan/Acca'),
('Perniagaan Antarabangsa'),
('Statistik'),
('Syariah'),
('Undang-Undang');



UPDATE `pg_field` SET `is_main` = '1';
UPDATE `pg_field` SET `is_main` = '0' WHERE `pg_field`.`id` = 5;
ALTER TABLE `pg_sv_field` ADD `sub_fields` TEXT NULL DEFAULT NULL AFTER `field_id`;