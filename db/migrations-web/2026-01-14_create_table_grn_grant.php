<?php

class m20260114_create_table_grn_grant
{
    public function up()
    {
        $db = \Yii::$app->db;

        $db->createCommand("
            CREATE TABLE IF NOT EXISTS `grn_type` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `type_name` VARCHAR(255) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `ux_grn_type_type_name` (`type_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ")->execute();

        $db->createCommand("
            CREATE TABLE IF NOT EXISTS `grn_category` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `category_name` VARCHAR(255) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `ux_grn_category_category_name` (`category_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ")->execute();

        $db->createCommand("
            CREATE TABLE IF NOT EXISTS `grn_grant` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `grant_title` TEXT NOT NULL,
              `project_code` VARCHAR(255) NULL,
              `category_id` INT NOT NULL,
              `type_id` INT NOT NULL,
              `head_researcher_id` INT NULL,
              `head_researcher_name` VARCHAR(255) NOT NULL,
              `amount` DECIMAL(12,2) NOT NULL,
              `date_start` DATE NOT NULL,
              `date_end` DATE NULL,
              `is_extended` TINYINT(1) NOT NULL DEFAULT 0,
              PRIMARY KEY (`id`),
              KEY `idx_grn_grant_category_id` (`category_id`),
              KEY `idx_grn_grant_type_id` (`type_id`),
              KEY `idx_grn_grant_head_researcher_id` (`head_researcher_id`),
              CONSTRAINT `fk_grn_grant_category_id` FOREIGN KEY (`category_id`) REFERENCES `grn_category` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
              CONSTRAINT `fk_grn_grant_type_id` FOREIGN KEY (`type_id`) REFERENCES `grn_type` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
              CONSTRAINT `fk_grn_grant_head_researcher_id` FOREIGN KEY (`head_researcher_id`) REFERENCES `pg_supervisor` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ")->execute();

        $root = dirname(__DIR__, 2);

        $this->importSingleColumnCsv(
            $db,
            $root . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'grant' . DIRECTORY_SEPARATOR . 'grant_type.csv',
            'grn_type',
            'type_name'
        );

        $this->importSingleColumnCsv(
            $db,
            $root . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'grant' . DIRECTORY_SEPARATOR . 'grant_category.csv',
            'grn_category',
            'category_name'
        );

        $types = $db->createCommand('SELECT `id`, `type_name` FROM `grn_type`')->queryAll();
        $categories = $db->createCommand('SELECT `id`, `category_name` FROM `grn_category`')->queryAll();

        $typeMap = [];
        foreach ($types as $t) {
            $typeMap[$t['type_name']] = (int) $t['id'];
        }

        $categoryMap = [];
        foreach ($categories as $c) {
            $categoryMap[$c['category_name']] = (int) $c['id'];
        }

        $grantCsv = $root . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'grant' . DIRECTORY_SEPARATOR . 'grant_data.csv';
        if (is_file($grantCsv) && is_readable($grantCsv)) {
            $handle = fopen($grantCsv, 'r');
            if ($handle !== false) {
                $header = fgetcsv($handle);
                $rows = [];

                while (($data = fgetcsv($handle)) !== false) {
                    if (!$data || count(array_filter($data, function ($v) {
                        return $v !== null && $v !== '';
                    })) === 0) {
                        continue;
                    }

                    $row = array_combine($header, $data);

                    $grantTitle = $this->toUtf8(trim((string) ($row['grant_title'] ?? '')));
                    $projectCode = $this->toUtf8(trim((string) ($row['project_code'] ?? '')));
                    $categoryName = $this->toUtf8(trim((string) ($row['grant_category'] ?? '')));
                    $typeName = $this->toUtf8(trim((string) ($row['grant_type'] ?? '')));
                    $headResearcherName = $this->toUtf8(trim((string) ($row['head_researcher'] ?? '')));

                    $amountRaw = $row['amount'] ?? 0;
                    $amount = is_numeric($amountRaw) ? (float) $amountRaw : (float) preg_replace('/[^0-9.\-]/', '', (string) $amountRaw);

                    $dateStart = trim((string) ($row['date_start'] ?? ''));

                    $dateEndRaw = trim((string) ($row['date_end'] ?? ''));
                    $isExtendedRaw = trim((string) ($row['is_extended (yes,no)'] ?? '0'));

                    // Some source rows appear to be ordered as: date_start,is_extended,date_end
                    // even though the CSV header says: date_start,date_end,is_extended.
                    // Detect and normalize.
                    if (preg_match('/^(0|1)$/', $dateEndRaw) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $isExtendedRaw)) {
                        $tmp = $dateEndRaw;
                        $dateEndRaw = $isExtendedRaw;
                        $isExtendedRaw = $tmp;
                    }

                    $dateEnd = $dateEndRaw;
                    if ($dateEnd === '0' || $dateEnd === '') {
                        $dateEnd = null;
                    }

                    $isExtended = 0;
                    if ($isExtendedRaw === '1' || strtolower($isExtendedRaw) === 'yes') {
                        $isExtended = 1;
                    }

                    if ($grantTitle === '' || $categoryName === '' || $typeName === '' || $headResearcherName === '' || $dateStart === '') {
                        continue;
                    }

                    if (!isset($categoryMap[$categoryName]) || !isset($typeMap[$typeName])) {
                        continue;
                    }

                    $rows[] = [
                        $grantTitle,
                        $projectCode !== '' ? $projectCode : null,
                        $categoryMap[$categoryName],
                        $typeMap[$typeName],
                        null,
                        $headResearcherName,
                        $amount,
                        $dateStart,
                        $dateEnd,
                        $isExtended,
                    ];
                }

                fclose($handle);

                if (!empty($rows)) {
                    $db->createCommand()->batchInsert(
                        'grn_grant',
                        ['grant_title', 'project_code', 'category_id', 'type_id', 'head_researcher_id', 'head_researcher_name', 'amount', 'date_start', 'date_end', 'is_extended'],
                        $rows
                    )->execute();
                }
            }
        }
    }

    private function importSingleColumnCsv($db, $path, $table, $column)
    {
        if (!is_file($path) || !is_readable($path)) {
            return;
        }

        $handle = fopen($path, 'r');
        if ($handle === false) {
            return;
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return;
        }

        $values = [];
        while (($data = fgetcsv($handle)) !== false) {
            if (!$data || !isset($data[0])) {
                continue;
            }

            $val = $this->toUtf8(trim((string) $data[0]));
            if ($val === '') {
                continue;
            }

            $values[$val] = [$val];
        }

        fclose($handle);

        if (empty($values)) {
            return;
        }

        $db->createCommand()->batchInsert($table, [$column], array_values($values))->execute();
    }

    private function toUtf8($value)
    {
        if ($value === null) {
            return null;
        }

        $value = (string) $value;
        if ($value === '') {
            return $value;
        }

        if (@preg_match('//u', $value)) {
            return $value;
        }

        $converted = @iconv('Windows-1252', 'UTF-8//IGNORE', $value);
        if ($converted !== false && $converted !== '') {
            return $converted;
        }

        $converted = @iconv('ISO-8859-1', 'UTF-8//IGNORE', $value);
        if ($converted !== false && $converted !== '') {
            return $converted;
        }

        return preg_replace('/[^\x00-\x7F]/', '', $value);
    }
}
