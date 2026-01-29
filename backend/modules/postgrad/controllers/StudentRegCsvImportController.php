<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\StringHelper;
use yii\web\Controller;
use backend\models\Semester;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\postgrad\models\StudentRegCsvUploadForm;

class StudentRegCsvImportController extends Controller
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

    public function actionIndex()
    {
        $model = new StudentRegCsvUploadForm();

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
                $map = Yii::$app->session->get('postgrad_student_reg_csv_tokens', []);
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

        return $this->render('index', [
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
        $headerRaw = [];
        $header = [];

        $stats = [
            'processed' => 0,
            'created' => 0,
            'updated' => 0,
            'no_changes' => 0,
            'not_found' => 0,
            'invalid' => 0,
            'errors' => 0,
            'applied' => $apply ? 1 : 0,
        ];

        $resultCounts = [
            'READY' => 0,
            'NO_CHANGES' => 0,
            'NOT_FOUND' => 0,
            'INVALID' => 0,
            'UPDATED' => 0,
            'CREATED' => 0,
            'FAILED' => 0,
        ];

        $preview = [];

        while (($data = fgetcsv($handle)) !== false) {
            $row++;

            if ($row === 1) {
                $headerRaw = $data;
                $header = array_map([$this, 'normalizeHeaderForMatch'], $data);

                $required = ['no matrik', 'matrik', 'matric'];
                $hasMatric = $this->findHeaderIndexByKeywords($header, $required) !== null;
                $hasFirstSemester = $this->findHeaderIndexByKeywords($header, ['first semester', 'first_semester', 'firstsemester']) !== null;

                if (!$hasMatric || !$hasFirstSemester) {
                    fclose($handle);
                    return [[], ['error' => 'Missing required column(s): NO. MATRIK and/or first_semester']];
                }

                continue;
            }

            $matric = $this->normalizeCellValue($this->getValueByKeywords($data, $header, ['no matrik', 'matrik', 'matric']));
            $firstSemesterRaw = $this->normalizeCellValue($this->getValueByKeywords($data, $header, ['first semester', 'first_semester', 'firstsemester']));

            if ($matric === '' || $firstSemesterRaw === '') {
                $stats['invalid']++;
                $resultCounts['INVALID']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'result' => 'INVALID',
                    'message' => 'Missing MATRIC or first_semester',
                ];
                continue;
            }

            $student = Student::find()->where(['matric_no' => $matric])->one();
            if (!$student) {
                $stats['not_found']++;
                $resultCounts['NOT_FOUND']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'result' => 'NOT_FOUND',
                    'message' => 'Student not found in pg_student',
                ];
                continue;
            }

            $firstSemesterId = $this->normalizeSemesterId($firstSemesterRaw);
            if (!$firstSemesterId) {
                $stats['invalid']++;
                $resultCounts['INVALID']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'result' => 'INVALID',
                    'message' => 'Invalid first_semester value',
                ];
                continue;
            }

            $ops = [];

            $ops[] = [
                'semester_id' => $firstSemesterId,
                'cell' => '',
                'col' => 'first_semester',
                'is_first' => 1,
            ];

            foreach ($headerRaw as $idx => $hRaw) {
                $hNorm = $header[$idx] ?? '';
                if ($hNorm === '' || $hNorm === 'first semester' || $hNorm === 'first_semester') {
                    continue;
                }

                $semCandidate = preg_replace('/[^0-9]/', '', (string)$hRaw);
                if (strlen($semCandidate) !== 9) {
                    continue;
                }

                $cell = isset($data[$idx]) ? $data[$idx] : null;
                $cellNorm = $this->normalizeCellValue($cell);
                if ($cellNorm === '') {
                    continue;
                }

                $semId = $this->normalizeSemesterId($semCandidate);
                if (!$semId) {
                    $ops[] = [
                        'semester_id' => null,
                        'cell' => $cellNorm,
                        'col' => (string)$hRaw,
                        'invalid_sem' => 1,
                    ];
                    continue;
                }

                $ops[] = [
                    'semester_id' => $semId,
                    'cell' => $cellNorm,
                    'col' => (string)$hRaw,
                ];
            }

            if (empty($ops)) {
                $stats['no_changes']++;
                $resultCounts['NO_CHANGES']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'result' => 'NO_CHANGES',
                    'message' => 'No semester data found',
                ];
                continue;
            }

            $rowChanges = [];
            $hasRealChange = false;
            $rowInvalid = false;
            $rowInvalidMessage = '';

            foreach ($ops as $op) {
                if (!empty($op['invalid_sem'])) {
                    $rowInvalid = true;
                    $rowInvalidMessage = 'Invalid semester column: ' . (string)($op['col'] ?? '');
                    continue;
                }

                $semesterId = (int)$op['semester_id'];
                $remark = $this->normalizeCellValue((string)$op['cell']);

                $isFirst = !empty($op['is_first']);
                if ($isFirst) {
                    $remark = '';
                }

                $isTangguh = $this->containsTangguh($remark);
                $statusDaftar = $isTangguh ? StudentRegister::STATUS_DAFTAR_TANGGUH : StudentRegister::STATUS_DAFTAR_DAFTAR;
                $statusAktif = $isTangguh ? StudentRegister::STATUS_AKTIF_TIDAK_AKTIF : StudentRegister::STATUS_AKTIF_AKTIF;

                $dateRegister = $isFirst ? null : $this->extractDateFromText($remark);

                $existing = StudentRegister::find()->where([
                    'student_id' => (int)$student->id,
                    'semester_id' => $semesterId,
                ])->one();

                $before = [
                    'status_daftar' => $existing ? (string)$existing->status_daftar : null,
                    'status_aktif' => $existing ? (string)$existing->status_aktif : null,
                    'remark' => $existing ? (string)$existing->remark : null,
                    'date_register' => $existing ? (string)$existing->date_register : null,
                ];

                $after = [
                    'status_daftar' => (string)$statusDaftar,
                    'status_aktif' => (string)$statusAktif,
                    'remark' => $remark,
                    'date_register' => $dateRegister,
                ];

                $changed = ($before != $after);
                if ($changed) {
                    $hasRealChange = true;
                }

                $keyPrefix = 'sem_' . $semesterId;
                $rowChanges = array_merge($rowChanges, $this->diffAssoc($this->prefixKeys($before, $keyPrefix), $this->prefixKeys($after, $keyPrefix)));

                if (!$apply) {
                    continue;
                }

                if (!$changed) {
                    continue;
                }

                $tx = Yii::$app->db->beginTransaction();
                try {
                    $isNew = false;
                    if (!$existing) {
                        $existing = new StudentRegister();
                        $existing->student_id = (int)$student->id;
                        $existing->semester_id = $semesterId;
                        $isNew = true;
                    }

                    $existing->status_daftar = $statusDaftar;
                    $existing->status_aktif = $statusAktif;
                    $existing->remark = $remark;
                    $existing->date_register = $dateRegister;

                    if (!$existing->save(false)) {
                        throw new \RuntimeException('Failed to save pg_student_reg');
                    }

                    $tx->commit();

                    if ($isNew) {
                        $stats['created']++;
                    } else {
                        $stats['updated']++;
                    }
                } catch (\Throwable $e) {
                    $tx->rollBack();
                    $stats['errors']++;
                    $resultCounts['FAILED']++;
                    $preview[] = [
                        'matric_no' => $matric,
                        'result' => 'FAILED',
                        'message' => StringHelper::truncate((string)$e->getMessage(), 180),
                        'changes' => $rowChanges,
                    ];
                    continue 2;
                }
            }

            if ($rowInvalid) {
                $stats['invalid']++;
                $resultCounts['INVALID']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'result' => 'INVALID',
                    'message' => $rowInvalidMessage !== '' ? $rowInvalidMessage : 'Invalid data',
                    'changes' => $rowChanges,
                ];
                continue;
            }

            $stats['processed']++;

            if (!$hasRealChange) {
                $stats['no_changes']++;
                $resultCounts['NO_CHANGES']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'result' => 'NO_CHANGES',
                    'message' => 'No changes',
                    'changes' => $rowChanges,
                ];
                continue;
            }

            if (!$apply) {
                $resultCounts['READY']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'result' => 'READY',
                    'message' => 'Will be inserted/updated',
                    'changes' => $rowChanges,
                ];
            } else {
                $resultCounts['UPDATED']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'result' => 'UPDATED',
                    'message' => 'Inserted/updated',
                    'changes' => $rowChanges,
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
            return false;
        }

        $first2 = fread($fh, 2);
        rewind($fh);

        if ($first2 === "\xFF\xFE" || $first2 === "\xFE\xFF") {
            $contents = file_get_contents($path);
            if ($contents === false) {
                fclose($fh);
                return false;
            }

            $enc = ($first2 === "\xFF\xFE") ? 'UTF-16LE' : 'UTF-16BE';
            $utf8 = mb_convert_encoding($contents, 'UTF-8', $enc);
            $tmp = tmpfile();
            if (!$tmp) {
                fclose($fh);
                return false;
            }
            fwrite($tmp, $utf8);
            rewind($tmp);
            fclose($fh);
            return $tmp;
        }

        return $fh;
    }

    private function normalizeCellValue($val)
    {
        if ($val === null) {
            return '';
        }

        $v = (string)$val;

        $v = ltrim($v, "\xEF\xBB\xBF");
        $v = str_replace(["\x00", "\x1A", "\u{200B}", "\u{FEFF}", "\u{00A0}"], '', $v);

        if ($v !== '' && function_exists('mb_check_encoding') && !mb_check_encoding($v, 'UTF-8')) {
            $fixed = false;
            if (function_exists('iconv')) {
                $tmp = @iconv('UTF-8', 'UTF-8//IGNORE', $v);
                if (is_string($tmp)) {
                    $v = $tmp;
                    $fixed = true;
                }
            }
            if (!$fixed) {
                $v = mb_convert_encoding($v, 'UTF-8', 'UTF-8');
            }
        }

        $v = trim($v);
        return $v;
    }

    private function normalizeHeaderForMatch($val)
    {
        $v = trim((string)$val);
        $v = ltrim($v, "\xEF\xBB\xBF");
        $v = str_replace(["\u{200B}"], '', $v);
        $v = mb_strtolower($v);
        $v = preg_replace('/[\s\._-]+/', ' ', $v);
        $v = preg_replace('/[^\p{L}\p{N} ]+/u', ' ', (string)$v);
        $v = preg_replace('/\s+/', ' ', (string)$v);
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

    private function normalizeSemesterId($raw)
    {
        $v = preg_replace('/\D+/', '', (string)$raw);
        if (strlen($v) !== 9) {
            return null;
        }

        $sem = Semester::find()->where(['id' => $v])->one();
        if ($sem) {
            return (int)$sem->id;
        }

        return null;
    }

    private function containsTangguh($text)
    {
        $t = mb_strtolower((string)$text, 'UTF-8');
        return (strpos($t, 'tangguh') !== false) || (strpos($t, 'penangguhan') !== false);
    }

    private function extractDateFromText($text)
    {
        $t = trim((string)$text);
        if ($t === '') {
            return null;
        }

        $months = [
            'januari' => 1,
            'jan' => 1,
            'februari' => 2,
            'feb' => 2,
            'mac' => 3,
            'march' => 3,
            'apr' => 4,
            'april' => 4,
            'mei' => 5,
            'may' => 5,
            'jun' => 6,
            'june' => 6,
            'jul' => 7,
            'julai' => 7,
            'july' => 7,
            'ogos' => 8,
            'aug' => 8,
            'august' => 8,
            'sept' => 9,
            'september' => 9,
            'okt' => 10,
            'oktober' => 10,
            'oct' => 10,
            'october' => 10,
            'nov' => 11,
            'november' => 11,
            'dis' => 12,
            'disember' => 12,
            'dec' => 12,
            'december' => 12,
        ];

        $lower = mb_strtolower($t, 'UTF-8');

        if (preg_match('/\b(\d{1,2})\s*[-\/.]\s*(\d{1,2})\s*[-\/.]\s*(\d{2,4})\b/', $lower, $m)) {
            $d = (int)$m[1];
            $mo = (int)$m[2];
            $y = (int)$m[3];
            if ($y < 100) {
                $y += 2000;
            }
            if (checkdate($mo, $d, $y)) {
                return sprintf('%04d-%02d-%02d', $y, $mo, $d);
            }
        }

        if (preg_match('/\b(\d{1,2})\s+([a-z\p{L}\.]+)\s+(\d{4})\b/u', $lower, $m)) {
            $d = (int)$m[1];
            $monText = trim((string)$m[2]);
            $monText = preg_replace('/\.+$/', '', $monText);
            $y = (int)$m[3];
            if (isset($months[$monText])) {
                $mo = (int)$months[$monText];
                if (checkdate($mo, $d, $y)) {
                    return sprintf('%04d-%02d-%02d', $y, $mo, $d);
                }
            }
        }

        $ts = strtotime($t);
        if ($ts !== false) {
            return date('Y-m-d', $ts);
        }

        return null;
    }

    private function diffAssoc(array $before, array $after)
    {
        $diff = [];
        $keys = array_unique(array_merge(array_keys($before), array_keys($after)));
        foreach ($keys as $k) {
            $b = $before[$k] ?? null;
            $a = $after[$k] ?? null;
            if ((string)$b !== (string)$a) {
                $diff[$k] = ['from' => $b, 'to' => $a];
            }
        }
        return $diff;
    }

    private function prefixKeys(array $arr, $prefix)
    {
        $out = [];
        foreach ($arr as $k => $v) {
            $out[$prefix . '_' . $k] = $v;
        }
        return $out;
    }
}
