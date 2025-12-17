<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentStatusUploadForm;

class StudentStatusController extends Controller
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
        $model = new StudentStatusUploadForm();

        $preview = null;
        $summary = null;

        if (Yii::$app->request->isPost) {
            $token = (string)Yii::$app->request->post('csv_token', '');
            $token = trim($token);

            if ($token === '') {
                $summary = ['error' => 'Please upload a CSV file first'];
            } else {
                $map = Yii::$app->session->get('postgrad_status_csv_tokens', []);
                $path = isset($map[$token]) ? $map[$token] : null;

                if (!$path || !is_string($path) || !is_file($path)) {
                    $summary = ['error' => 'Uploaded CSV file not found. Please upload again.'];
                } else {
                    [$preview, $summary] = $this->processCsv($path, false);

                    if (Yii::$app->request->post('apply') === '1') {
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
        $fh = fopen($path, 'r');
        if (!$fh) {
            return [[], ['error' => 'Unable to open uploaded CSV file']];
        }

        set_time_limit(0);

        // Pre-validate duplicates for Student Id (scan all rows once)
        $row = 0;
        $header = [];
        $cols = [];
        $studentIdKey = null;
        $seen = [];
        $duplicates = [];

        while (($data = fgetcsv($fh)) !== false) {
            $row++;
            if ($row === 1) {
                $header = array_map('strtolower', $data);
                $cols = array_flip($header);

                // Accept both student_id (preferred) and legacy "student id"
                if (isset($cols['student_id'])) {
                    $studentIdKey = 'student_id';
                } elseif (isset($cols['student id'])) {
                    $studentIdKey = 'student id';
                }

                $required = ['status_daftar', 'status_aktif'];
                $missing = [];
                if ($studentIdKey === null) {
                    $missing[] = 'student_id';
                }
                foreach ($required as $req) {
                    if (!isset($cols[$req])) {
                        $missing[] = $req;
                    }
                }

                if (!empty($missing)) {
                    fclose($fh);
                    return [[], ['error' => 'Missing required columns: ' . implode(', ', $missing)]];
                }

                continue;
            }

            $studentId = ($studentIdKey !== null && isset($data[$cols[$studentIdKey]])) ? trim((string)$data[$cols[$studentIdKey]]) : '';
            if ($studentId === '') {
                continue;
            }

            if (isset($seen[$studentId])) {
                $seen[$studentId]++;
                $duplicates[$studentId] = $seen[$studentId];
            } else {
                $seen[$studentId] = 1;
            }
        }

        if (!empty($duplicates)) {
            fclose($fh);
            ksort($duplicates);
            $list = [];
            foreach ($duplicates as $id => $count) {
                $list[] = $id . ' (' . $count . 'x)';
                if (count($list) >= 50) {
                    break;
                }
            }
            $msg = 'Duplicate Student Id found in CSV. Please remove duplicates before processing. ';
            $msg .= 'Duplicates: ' . implode(', ', $list);
            if (count($duplicates) > 50) {
                $msg .= ' ...';
            }
            return [[], ['error' => $msg]];
        }

        // Re-open for actual processing (to avoid relying on rewind support)
        fclose($fh);
        $fh = fopen($path, 'r');
        if (!$fh) {
            return [[], ['error' => 'Unable to open uploaded CSV file']];
        }

        $row = 0;
        $header = [];
        $cols = [];
        $studentIdKey = null;

        $stats = [
            'processed' => 0,
            'updated' => 0,
            'skipped' => 0,
            'not_found' => 0,
            'invalid_status' => 0,
            'errors' => 0,
            'applied' => $apply ? 1 : 0,
        ];

        $resultCounts = [
            'READY' => 0,
            'NO_CHANGES' => 0,
            'NOT_FOUND' => 0,
            'INVALID_STATUS' => 0,
            'UPDATED' => 0,
            'FAILED' => 0,
        ];

        $preview = [];

        while (($data = fgetcsv($fh)) !== false) {
            $row++;
            if ($row === 1) {
                $header = array_map('strtolower', $data);
                $cols = array_flip($header);

                if (isset($cols['student_id'])) {
                    $studentIdKey = 'student_id';
                } elseif (isset($cols['student id'])) {
                    $studentIdKey = 'student id';
                }

                continue;
            }

            $studentId = ($studentIdKey !== null && isset($data[$cols[$studentIdKey]])) ? trim((string)$data[$cols[$studentIdKey]]) : '';
            $statusDaftarText = isset($data[$cols['status_daftar']]) ? trim((string)$data[$cols['status_daftar']]) : '';
            $statusAktifText = isset($data[$cols['status_aktif']]) ? trim((string)$data[$cols['status_aktif']]) : '';

            if ($studentId === '') {
                $stats['skipped']++;
                continue;
            }

            $mappedDaftar = Student::mapStatusDaftarFromText($statusDaftarText);
            $mappedAktif = Student::mapStatusAktifFromText($statusAktifText);

            if ($mappedDaftar === false || $mappedAktif === false) {
                $stats['invalid_status']++;
                $resultCounts['INVALID_STATUS']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_aktif_text' => $statusAktifText,
                    'status_daftar' => $mappedDaftar,
                    'status_aktif' => $mappedAktif,
                    'result' => 'INVALID_STATUS',
                ];
                continue;
            }

            $student = Student::find()->where(['matric_no' => $studentId])->one();
            if (!$student) {
                $stats['not_found']++;
                $resultCounts['NOT_FOUND']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_aktif_text' => $statusAktifText,
                    'status_daftar' => $mappedDaftar,
                    'status_aktif' => $mappedAktif,
                    'current_status_daftar' => null,
                    'current_status_aktif' => null,
                    'current_status_daftar_text' => null,
                    'current_status_aktif_text' => null,
                    'daftar_changed' => false,
                    'aktif_changed' => false,
                    'result' => 'NOT_FOUND',
                ];
                continue;
            }

            $beforeDaftar = $student->status_daftar;
            $beforeAktif = $student->status_aktif;

            $currentDaftarText = $student->statusDaftarText;
            $currentAktifText = $student->statusAktifText;

            $daftarChanged = ($mappedDaftar !== null) && ((int)$beforeDaftar !== (int)$mappedDaftar);
            $aktifChanged = ($mappedAktif !== null) && ((int)$beforeAktif !== (int)$mappedAktif);

            $changed = false;
            if ($daftarChanged) {
                $student->status_daftar = $mappedDaftar;
                $changed = true;
            }
            if ($aktifChanged) {
                $student->status_aktif = $mappedAktif;
                $changed = true;
            }

            if (!$changed) {
                $stats['skipped']++;
                $resultCounts['NO_CHANGES']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_aktif_text' => $statusAktifText,
                    'status_daftar' => $mappedDaftar,
                    'status_aktif' => $mappedAktif,
                    'current_status_daftar' => $beforeDaftar,
                    'current_status_aktif' => $beforeAktif,
                    'current_status_daftar_text' => $currentDaftarText,
                    'current_status_aktif_text' => $currentAktifText,
                    'daftar_changed' => false,
                    'aktif_changed' => false,
                    'result' => 'NO_CHANGES',
                ];
                continue;
            }

            $stats['processed']++;

            if ($apply) {
                $student->scenario = 'student_update';
                if ($student->save(false)) {
                    $stats['updated']++;
                    $resultCounts['UPDATED']++;
                    $preview[] = [
                        'student_id' => $studentId,
                        'status_daftar_text' => $statusDaftarText,
                        'status_aktif_text' => $statusAktifText,
                        'status_daftar' => $mappedDaftar,
                        'status_aktif' => $mappedAktif,
                        'current_status_daftar' => $beforeDaftar,
                        'current_status_aktif' => $beforeAktif,
                        'current_status_daftar_text' => $currentDaftarText,
                        'current_status_aktif_text' => $currentAktifText,
                        'daftar_changed' => $daftarChanged,
                        'aktif_changed' => $aktifChanged,
                        'result' => 'UPDATED',
                    ];
                } else {
                    $stats['errors']++;
                    $resultCounts['FAILED']++;
                    $preview[] = [
                        'student_id' => $studentId,
                        'status_daftar_text' => $statusDaftarText,
                        'status_aktif_text' => $statusAktifText,
                        'status_daftar' => $mappedDaftar,
                        'status_aktif' => $mappedAktif,
                        'current_status_daftar' => $beforeDaftar,
                        'current_status_aktif' => $beforeAktif,
                        'current_status_daftar_text' => $currentDaftarText,
                        'current_status_aktif_text' => $currentAktifText,
                        'daftar_changed' => $daftarChanged,
                        'aktif_changed' => $aktifChanged,
                        'result' => 'FAILED',
                    ];
                }
            } else {
                $resultCounts['READY']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_aktif_text' => $statusAktifText,
                    'status_daftar' => $mappedDaftar,
                    'status_aktif' => $mappedAktif,
                    'current_status_daftar' => $beforeDaftar,
                    'current_status_aktif' => $beforeAktif,
                    'current_status_daftar_text' => $currentDaftarText,
                    'current_status_aktif_text' => $currentAktifText,
                    'daftar_changed' => $daftarChanged,
                    'aktif_changed' => $aktifChanged,
                    'result' => 'READY',
                ];
            }
        }

        fclose($fh);

        $stats['result_counts'] = $resultCounts;

        return [$preview, $stats];
    }
}
