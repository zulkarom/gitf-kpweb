-- Backfill per-semester statuses into pg_student_reg for the CURRENT semester.
-- Safe behaviour:
-- 1) Insert missing pg_student_reg rows for current semester.
-- 2) Update existing rows but do not overwrite non-NULL per-semester values.

-- Get current semester id
SET @semester_id := (SELECT id FROM semester WHERE is_current = 1 LIMIT 1);

-- Insert missing rows
INSERT INTO pg_student_reg (student_id, semester_id, status_daftar, status_aktif)
SELECT s.id, @semester_id, s.status_daftar, s.status_aktif
FROM pg_student s
LEFT JOIN pg_student_reg r
  ON r.student_id = s.id AND r.semester_id = @semester_id
WHERE @semester_id IS NOT NULL
  AND r.id IS NULL;

-- Backfill existing rows without overwrite
UPDATE pg_student_reg r
INNER JOIN pg_student s ON s.id = r.student_id
SET
  r.status_daftar = IF(r.status_daftar IS NULL, s.status_daftar, r.status_daftar),
  r.status_aktif  = IF(r.status_aktif IS NULL, s.status_aktif,  r.status_aktif)
WHERE @semester_id IS NOT NULL
  AND r.semester_id = @semester_id;
