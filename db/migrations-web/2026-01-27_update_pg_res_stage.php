<?php

class m20260127_update_pg_res_stage
{
    public function up()
    {
        $db = \Yii::$app->db;

        $table = 'pg_res_stage';

        $exists = (int)$db->createCommand("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t", [
            ':t' => $table,
        ])->queryScalar();

        if ($exists === 0) {
            $db->createCommand("CREATE TABLE `pg_res_stage` (
              `id` int(11) NOT NULL,
              `stage_name` varchar(100) DEFAULT NULL,
              `stage_name_en` varchar(100) DEFAULT NULL,
              `stage_abbr` varchar(20) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;")->execute();
        } else {
            $db->createCommand("ALTER TABLE `pg_res_stage` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;")->execute();

            $hasStageNo = (int)$db->createCommand("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = 'stage_no'", [
                ':t' => $table,
            ])->queryScalar();
            if ($hasStageNo > 0) {
                $db->createCommand("ALTER TABLE `pg_res_stage` DROP COLUMN `stage_no`;")->execute();
            }

            $hasId = (int)$db->createCommand("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = 'id'", [
                ':t' => $table,
            ])->queryScalar();
            if ($hasId === 0) {
                $db->createCommand("ALTER TABLE `pg_res_stage` ADD COLUMN `id` int(11) NOT NULL FIRST;")->execute();
            } else {
                $db->createCommand("ALTER TABLE `pg_res_stage` MODIFY COLUMN `id` int(11) NOT NULL;")->execute();
            }

            $hasStageName = (int)$db->createCommand("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = 'stage_name'", [
                ':t' => $table,
            ])->queryScalar();
            if ($hasStageName === 0) {
                $db->createCommand("ALTER TABLE `pg_res_stage` ADD COLUMN `stage_name` varchar(100) DEFAULT NULL;")->execute();
            } else {
                $db->createCommand("ALTER TABLE `pg_res_stage` MODIFY COLUMN `stage_name` varchar(100) DEFAULT NULL;")->execute();
            }

            $hasStageNameEn = (int)$db->createCommand("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = 'stage_name_en'", [
                ':t' => $table,
            ])->queryScalar();
            if ($hasStageNameEn === 0) {
                $db->createCommand("ALTER TABLE `pg_res_stage` ADD COLUMN `stage_name_en` varchar(100) DEFAULT NULL;")->execute();
            } else {
                $db->createCommand("ALTER TABLE `pg_res_stage` MODIFY COLUMN `stage_name_en` varchar(100) DEFAULT NULL;")->execute();
            }

            $hasStageAbbr = (int)$db->createCommand("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = 'stage_abbr'", [
                ':t' => $table,
            ])->queryScalar();
            if ($hasStageAbbr === 0) {
                $db->createCommand("ALTER TABLE `pg_res_stage` ADD COLUMN `stage_abbr` varchar(20) DEFAULT NULL;")->execute();
            } else {
                $db->createCommand("ALTER TABLE `pg_res_stage` MODIFY COLUMN `stage_abbr` varchar(20) DEFAULT NULL;")->execute();
            }

            $pk = $db->createCommand("SELECT k.COLUMN_NAME
                FROM information_schema.TABLE_CONSTRAINTS tc
                JOIN information_schema.KEY_COLUMN_USAGE k
                  ON tc.CONSTRAINT_NAME = k.CONSTRAINT_NAME
                 AND tc.TABLE_SCHEMA = k.TABLE_SCHEMA
                 AND tc.TABLE_NAME = k.TABLE_NAME
               WHERE tc.TABLE_SCHEMA = DATABASE()
                 AND tc.TABLE_NAME = :t
                 AND tc.CONSTRAINT_TYPE = 'PRIMARY KEY'
               ORDER BY k.ORDINAL_POSITION
               LIMIT 1", [
                ':t' => $table,
            ])->queryScalar();

            if (!$pk) {
                $db->createCommand("ALTER TABLE `pg_res_stage` ADD PRIMARY KEY (`id`);")->execute();
            }
        }

        $rows = [
            [10, 'Pendaftaran', 'Registration', 'REGISTER'],
            [20, 'Penilaian Cadangan Penyelidikan', 'Proposal Defense', 'PD'],
            [30, 'Penilaian Semula Cadangan Penyelidikan', 'Re-Proposal Defense', 'RePD'],
            [40, 'Pra Peperiksaan Lisan', 'Pre Viva Voce', 'PRE-VIVA'],
            [50, 'Pra Peperiksaan Lisan Semula', 'Re-Pre Viva Voce', 'Re-PREVIVA'],
            [60, 'Notis Penyerah', 'Notice Of Submission', 'NOS'],
            [70, 'Peperiksaan Lisan', 'Viva Voce', 'VIVA'],
            [80, 'Graduasi', 'Graduate', 'GRAD'],
        ];

        foreach ($rows as $r) {
            $db->createCommand(
                "INSERT INTO `pg_res_stage` (`id`, `stage_name`, `stage_name_en`, `stage_abbr`) VALUES " .
                "(:id, :ms, :en, :abbr) " .
                "ON DUPLICATE KEY UPDATE " .
                "`stage_name`=VALUES(`stage_name`), `stage_name_en`=VALUES(`stage_name_en`), `stage_abbr`=VALUES(`stage_abbr`)"
            , [
                ':id' => (int)$r[0],
                ':ms' => $r[1],
                ':en' => $r[2],
                ':abbr' => $r[3],
            ])->execute();
        }
    }
}
