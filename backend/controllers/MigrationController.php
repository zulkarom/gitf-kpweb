<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\helpers\FileHelper;
use yii\db\Expression;

class MigrationController extends Controller
{
    // CHANGE THIS to your own secret before using in production
    private const RUN_TOKEN = '123';

    // Directory where web migrations are stored
    // Physical path: @app/db/migrations-web
    private const MIGRATION_PATH_ALIAS = '@db/migrations-web';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // only logged-in users
                    ],
                ],
            ],
        ];
    }

    /**
     * Run all pending web migrations.
     * URL example: /migration/run?token=YOUR_SECRET
     */
    public function actionRun($token = null)
    {
        if ($token !== self::RUN_TOKEN) {
            throw new ForbiddenHttpException('Invalid token');
        }

        $db = Yii::$app->db;

        // Ensure migration table exists
        $db->createCommand("CREATE TABLE IF NOT EXISTS app_migration (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE,
            applied_at DATETIME NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci")->execute();

        $migrationPath = Yii::getAlias(self::MIGRATION_PATH_ALIAS);
        if (!is_dir($migrationPath)) {
            return 'Migration directory does not exist: ' . $migrationPath;
        }

        $files = FileHelper::findFiles($migrationPath, [
            'only' => ['*.php'],
        ]);

        if (empty($files)) {
            return 'No migration files found in: ' . $migrationPath;
        }

        // Sort by filename to get deterministic order
        sort($files, SORT_STRING);

        // Load applied migrations
        $applied = $db->createCommand('SELECT name FROM app_migration')->queryColumn();
        $applied = array_flip($applied); // for fast lookup

        $results = [];

        foreach ($files as $file) {
            $base = basename($file, '.php');
            $name = $base; // store as-is in app_migration.name

            if (isset($applied[$name])) {
                $results[] = "SKIP: $name (already applied)";
                continue;
            }

            // Derive class name from file name
            // Example: 2026-01-07_add_last_status_daftar_pg_student.php
            // becomes class m20260107_add_last_status_daftar_pg_student
            $class = 'm' . str_replace('-', '', $base);

            require_once $file;

            if (!class_exists($class)) {
                $results[] = "ERROR: Class $class not found in $name";
                continue;
            }

            $migration = new $class();

            $transaction = $db->beginTransaction();
            try {
                if (!method_exists($migration, 'up')) {
                    throw new \RuntimeException("Migration class $class has no up() method");
                }

                $migration->up();

                $db->createCommand()->insert('app_migration', [
                    'name' => $name,
                    'applied_at' => new Expression('NOW()'),
                ])->execute();

                $transaction->commit();
                $results[] = "OK: $name";
            } catch (\Throwable $e) {
                $transaction->rollBack();
                $results[] = "FAIL: $name - " . $e->getMessage();
                break; // stop on first failure
            }
        }

        return implode("\n", $results);
    }
}
