<?php

use yii\db\Migration;

class m20251217_235000_backfill_statuses_to_pg_student_reg extends Migration
{
    public function safeUp()
    {
        $semesterId = (new \yii\db\Query())
            ->select('id')
            ->from('{{%semester}}')
            ->where(['is_current' => 1])
            ->scalar($this->db);

        if (!$semesterId) {
            return;
        }

        // Create missing registration rows for current semester.
        $this->execute(
            'INSERT INTO {{%pg_student_reg}} (student_id, semester_id, status_daftar, status_aktif)\n'
            . 'SELECT s.id, :semesterId, s.status_daftar, s.status_aktif\n'
            . 'FROM {{%pg_student}} s\n'
            . 'LEFT JOIN {{%pg_student_reg}} r\n'
            . '  ON r.student_id = s.id AND r.semester_id = :semesterId\n'
            . 'WHERE r.id IS NULL',
            [':semesterId' => (int)$semesterId]
        );

        // Backfill existing registration rows but do not overwrite values already set.
        $this->execute(
            'UPDATE {{%pg_student_reg}} r\n'
            . 'INNER JOIN {{%pg_student}} s ON s.id = r.student_id\n'
            . 'SET\n'
            . '  r.status_daftar = IF(r.status_daftar IS NULL, s.status_daftar, r.status_daftar),\n'
            . '  r.status_aktif = IF(r.status_aktif IS NULL, s.status_aktif, r.status_aktif)\n'
            . 'WHERE r.semester_id = :semesterId',
            [':semesterId' => (int)$semesterId]
        );
    }

    public function safeDown()
    {
        return false;
    }
}
