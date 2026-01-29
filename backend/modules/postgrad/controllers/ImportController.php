<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\modules\postgrad\models\ThesisTitleCsvUploadForm;

class ImportController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionTitle()
    {
        $model = new ThesisTitleCsvUploadForm();

        $preview = null;
        $summary = null;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->load($post);

            $token = (string)Yii::$app->request->post('csv_token', '');
            $token = trim($token);

            if ($token === '') {
                $summary = ['error' => 'Please upload a CSV file first'];
            } else {
                $map = Yii::$app->session->get('postgrad_thesis_title_csv_tokens', []);
                $path = isset($map[$token]) ? $map[$token] : null;

                if (!$path || !is_string($path) || !is_file($path)) {
                    $summary = ['error' => 'Uploaded CSV file not found. Please upload again.'];
                } else {
                    [$preview, $summary] = $this->processCsv($path, false);

                    $applyIntent = (string)Yii::$app->request->post('apply_intent', '0');
                    $applyIntent = trim($applyIntent);

                    if ($applyIntent === '1') {
                        [$preview, $summary] = $this->processCsv($path, true);
                    }
                }
            }
        }

        return $this->render('title', [
            'model' => $model,
            'preview' => $preview,
            'summary' => $summary,
        ]);
    }

    private function processCsv($path, $apply)
    {
        set_time_limit(0);

        $handle = $this->openCsvHandle($path);
        if (!$handle) {
            return [[], ['error' => 'Unable to open uploaded CSV file']];
        }

        $row = 0;
        $header = [];

        $stats = [
            'processed' => 0,
            'inserted' => 0,
            'exists' => 0,
            'invalid' => 0,
            'errors' => 0,
            'applied' => $apply ? 1 : 0,
        ];

        $resultCounts = [
            'READY' => 0,
            'EXISTS' => 0,
            'INVALID' => 0,
            'INSERTED' => 0,
            'FAILED' => 0,
        ];

        $preview = [];

        $db = Yii::$app->db;
        $detectDebug = '';
        $titleColumn = $this->detectTitleColumn($db, $detectDebug);
        if ($titleColumn === null) {
            fclose($handle);
            $msg = 'Unable to detect title column in pg_thesis_title.';
            if ($detectDebug !== '') {
                $msg .= ' ' . $detectDebug;
            }
            return [[], ['error' => $msg]];
        }

        while (($data = fgetcsv($handle)) !== false) {
            $row++;

            if ($row === 1) {
                $header = array_map([$this, 'normalizeHeaderForMatch'], $data);
                $hasTitle = $this->findHeaderIndexByKeywords($header, ['tajuk penyelidikan', 'tajuk', 'title', 'thesis_title']) !== null;
                if (!$hasTitle) {
                    fclose($handle);
                    return [[], ['error' => 'Missing required column: TAJUK PENYELIDIKAN (or TITLE)']];
                }
                continue;
            }

            $title = $this->normalizeCellValue($this->getValueByKeywords($data, $header, ['tajuk penyelidikan', 'tajuk', 'title', 'thesis_title']));

            if ($title === '') {
                $stats['invalid']++;
                $resultCounts['INVALID']++;
                $preview[] = [
                    'row' => $row,
                    'title' => $title,
                    'result' => 'INVALID',
                    'message' => 'Missing title',
                ];
                continue;
            }

            $stats['processed']++;

            try {
                $exists = (int)$db->createCommand(
                    "SELECT COUNT(*) FROM pg_thesis_title WHERE {$titleColumn} = :t",
                    [':t' => $title]
                )->queryScalar();

                if ($exists > 0) {
                    $stats['exists']++;
                    $resultCounts['EXISTS']++;
                    $preview[] = [
                        'row' => $row,
                        'title' => $title,
                        'result' => 'EXISTS',
                        'message' => 'Title already exists',
                    ];
                    continue;
                }

                $resultCounts['READY']++;
                $previewRow = [
                    'row' => $row,
                    'title' => $title,
                    'result' => 'READY',
                    'message' => 'Will insert',
                ];

                if ($apply) {
                    $ok = (int)$db->createCommand()->insert('pg_thesis_title', [
                        $titleColumn => $title,
                    ])->execute();

                    if ($ok > 0) {
                        $stats['inserted']++;
                        $resultCounts['INSERTED']++;
                        $previewRow['result'] = 'INSERTED';
                        $previewRow['message'] = 'Inserted';
                    } else {
                        $stats['errors']++;
                        $resultCounts['FAILED']++;
                        $previewRow['result'] = 'FAILED';
                        $previewRow['message'] = 'Insert returned 0';
                    }
                }

                $preview[] = $previewRow;
            } catch (\Throwable $e) {
                $stats['errors']++;
                $resultCounts['FAILED']++;
                $preview[] = [
                    'row' => $row,
                    'title' => $title,
                    'result' => 'FAILED',
                    'message' => $e->getMessage(),
                ];
            }
        }

        fclose($handle);
        $stats['result_counts'] = $resultCounts;

        return [$preview, $stats];
    }

    private function openCsvHandle($path)
    {
        $fh = fopen($path, 'r');
        if (!$fh) {
            return null;
        }

        $b1 = fread($fh, 3);
        if ($b1 !== "\xEF\xBB\xBF") {
            rewind($fh);
        }

        return $fh;
    }

    private function normalizeHeaderForMatch($val)
    {
        $v = trim((string)$val);
        $v = ltrim($v, "\xEF\xBB\xBF");
        $v = mb_strtolower($v);
        $v = preg_replace('/\s+/', ' ', $v);
        return trim((string)$v);
    }

    private function findHeaderIndexByKeywords(array $normalizedHeaders, array $keywords)
    {
        foreach ($normalizedHeaders as $idx => $h) {
            foreach ($keywords as $kw) {
                $nkw = $this->normalizeHeaderForMatch($kw);
                if ($nkw !== '' && mb_strpos((string)$h, (string)$nkw) !== false) {
                    return (int)$idx;
                }
            }
        }
        return null;
    }

    private function getValueByKeywords(array $row, array $normalizedHeaders, array $keywords)
    {
        $idx = $this->findHeaderIndexByKeywords($normalizedHeaders, $keywords);
        if ($idx === null) {
            return null;
        }
        return isset($row[$idx]) ? $row[$idx] : null;
    }

    private function normalizeCellValue($val)
    {
        if ($val === null) {
            return '';
        }
        $v = trim((string)$val);
        $v = preg_replace('/\s+/', ' ', $v);
        return trim((string)$v);
    }

    private function detectTitleColumn($db, &$debug = '')
    {
        $errors = [];

        try {
            $schema = $db->schema->getTableSchema('pg_thesis_title', true);
        } catch (\Throwable $e) {
            $schema = null;
            $errors[] = 'Schema error: ' . $e->getMessage();
        }

        if (!$schema) {
            $errors[] = 'Table schema not found (table missing or not accessible on current DB connection).';
        }

        try {
            $db->createCommand('SELECT thesis_title FROM pg_thesis_title LIMIT 0')->queryAll();
            return 'thesis_title';
        } catch (\Throwable $e) {
            $errors[] = 'Probe thesis_title failed: ' . $e->getMessage();
        }

        $preferred = ['title', 'thesis_title', 'tajuk_penyelidikan', 'tajuk'];

        if ($schema && is_array($schema->columns) && !empty($schema->columns)) {
            $cols = array_keys($schema->columns);

            foreach ($preferred as $p) {
                foreach ($cols as $c) {
                    if (strcasecmp((string)$c, (string)$p) === 0) {
                        return (string)$c;
                    }
                }
            }

            foreach ($cols as $c) {
                $lc = strtolower((string)$c);
                if (strpos($lc, 'title') !== false) {
                    return (string)$c;
                }
            }
        }

        foreach ($preferred as $col) {
            try {
                $db->createCommand("SELECT {$col} FROM pg_thesis_title LIMIT 0")->queryAll();
                return (string)$col;
            } catch (\Throwable $e) {
                $errors[] = 'Probe ' . $col . ' failed: ' . $e->getMessage();
            }
        }

        foreach (['research_title', 'project_title'] as $col) {
            try {
                $db->createCommand("SELECT {$col} FROM pg_thesis_title LIMIT 0")->queryAll();
                return (string)$col;
            } catch (\Throwable $e) {
                $errors[] = 'Probe ' . $col . ' failed: ' . $e->getMessage();
            }
        }

        if (!empty($errors)) {
            $debug = 'Details: ' . implode(' | ', $errors);
        }

        return null;
    }
}
