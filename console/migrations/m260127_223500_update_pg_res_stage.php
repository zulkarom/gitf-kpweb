<?php

use yii\db\Migration;

/**
 * Handles updating table `pg_res_stage` structure and seeding base stages.
 */
class m260127_223500_update_pg_res_stage extends Migration
{
    public function safeUp()
    {
        $table = 'pg_res_stage';
        $schema = $this->db->schema->getTableSchema($table, true);

        $tableOptions = 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci';

        if ($schema === null) {
            $this->createTable($table, [
                'id' => $this->integer(11)->notNull(),
                'stage_no' => $this->tinyInteger(3)->defaultValue(null),
                'stage_name' => $this->string(100)->defaultValue(null),
                'stage_name_en' => $this->string(100)->defaultValue(null),
                'stage_abbr' => $this->string(20)->defaultValue(null),
            ], $tableOptions);

            $this->addPrimaryKey('pk_pg_res_stage_id', $table, 'id');
        } else {
            $this->execute('ALTER TABLE `' . $table . '` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');

            if (!isset($schema->columns['id'])) {
                $this->addColumn($table, 'id', $this->integer(11)->notNull());
            } else {
                $this->alterColumn($table, 'id', $this->integer(11)->notNull());
            }

            if (!isset($schema->columns['stage_no'])) {
                $this->addColumn($table, 'stage_no', $this->tinyInteger(3)->defaultValue(null));
            } else {
                $this->alterColumn($table, 'stage_no', $this->tinyInteger(3)->defaultValue(null));
            }

            if (!isset($schema->columns['stage_name'])) {
                $this->addColumn($table, 'stage_name', $this->string(100)->defaultValue(null));
            } else {
                $this->alterColumn($table, 'stage_name', $this->string(100)->defaultValue(null));
            }

            if (!isset($schema->columns['stage_name_en'])) {
                $this->addColumn($table, 'stage_name_en', $this->string(100)->defaultValue(null));
            } else {
                $this->alterColumn($table, 'stage_name_en', $this->string(100)->defaultValue(null));
            }

            if (!isset($schema->columns['stage_abbr'])) {
                $this->addColumn($table, 'stage_abbr', $this->string(20)->defaultValue(null));
            } else {
                $this->alterColumn($table, 'stage_abbr', $this->string(20)->defaultValue(null));
            }

            $schema = $this->db->schema->getTableSchema($table, true);
            if (empty($schema->primaryKey)) {
                $this->addPrimaryKey('pk_pg_res_stage_id', $table, 'id');
            }
        }

        $rows = [
            [1, 10, 'Pendaftaran', 'Registration', 'REGISTER'],
            [2, 20, 'Penilaian Cadangan Penyelidikan', 'Proposal Defense', 'PD'],
            [3, 30, 'Penilaian Semula Cadangan Penyelidikan', 'Re-Proposal Defense', 'RePD'],
            [4, 40, 'Pra Peperiksaan Lisan', 'Pre Viva Voce', 'PRE-VIVA'],
            [5, 50, 'Pra Peperiksaan Lisan Semula', 'Re-Pre Viva Voce', 'Re-PREVIVA'],
            [6, 60, 'Notis Penyerah', 'Notice Of Submission', 'NOS'],
            [7, 70, 'Peperiksaan Lisan', 'Viva Voce', 'VIVA'],
            [8, 80, 'Graduasi', 'Graduate', 'GRAD'],
        ];

        foreach ($rows as $r) {
            $this->execute(
                'INSERT INTO `' . $table . '` (`id`, `stage_no`, `stage_name`, `stage_name_en`, `stage_abbr`) VALUES ' .
                '(' . (int)$r[0] . ', ' . (int)$r[1] . ', ' . $this->db->quoteValue($r[2]) . ', ' . $this->db->quoteValue($r[3]) . ', ' . $this->db->quoteValue($r[4]) . ') ' .
                'ON DUPLICATE KEY UPDATE ' .
                '`stage_no`=VALUES(`stage_no`), `stage_name`=VALUES(`stage_name`), `stage_name_en`=VALUES(`stage_name_en`), `stage_abbr`=VALUES(`stage_abbr`)' 
            );
        }
    }

    public function safeDown()
    {
        return false;
    }
}
