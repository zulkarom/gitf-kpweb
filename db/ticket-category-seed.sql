-- Seed data for ticket_category

INSERT INTO `ticket_category` (`name`, `code`, `sort_order`, `is_active`) VALUES
('Postgraduate', 'postgrad', 10, 1),
('Staff Information', 'staff_info', 20, 1),
('Student Information', 'student_info', 30, 1),
('Course Management', 'course_mgmt', 40, 1),
('Program Management', 'program_mgmt', 50, 1),
('Internship / Protege', 'internship_protege', 60, 1),
('System / Technical Issue', 'system_tech', 70, 1),
('Other', 'other', 99, 1);
