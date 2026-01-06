<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\postgrad\models\StudentStatusUploadForm;
use backend\models\Semester;

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

        $currentSem = Semester::getCurrentSemester();
        if ($currentSem) {
            $model->semester_id = $currentSem->id;
        }

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
                $map = Yii::$app->session->get('postgrad_status_csv_tokens', []);
                $path = isset($map[$token]) ? $map[$token] : null;

                if (!$path || !is_string($path) || !is_file($path)) {
                    $summary = ['error' => 'Uploaded CSV file not found. Please upload again.'];
                } else {
                    [$preview, $summary] = $this->processCsv($path, false, (int)$model->semester_id);

                    if (Yii::$app->request->post('apply') === '1') {
                        [$preview, $summary] = $this->processCsv($path, true, (int)$model->semester_id);
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

    public function actionDownloadCsv($semester_id)
    {
        $semesterId = (int)$semester_id;
        if ($semesterId <= 0) {
            Yii::$app->session->addFlash('error', 'Please select Semester');
            return $this->redirect(['index']);
        }

        $semester = Semester::findOne($semesterId);
        if (!$semester) {
            Yii::$app->session->addFlash('error', 'Semester not found');
            return $this->redirect(['index']);
        }

        $safeSem = preg_replace('/[^A-Za-z0-9_\-]+/', '_', (string)$semester->longFormat());
        $filename = 'student_status_' . $safeSem . '.csv';

        $fp = fopen('php://temp', 'w+');
        if ($fp === false) {
            throw new \yii\web\ServerErrorHttpException('Unable to create CSV stream');
        }

        fwrite($fp, "\xEF\xBB\xBF");
        fputcsv($fp, ['student_id', 'student_name', 'status_daftar']);

        $query = Student::find()
            ->alias('s')
            ->select([
                's.matric_no AS matric_no',
                'u.fullname AS student_name',
                'r.status_daftar AS status_daftar',
                'r.status_aktif AS status_aktif',
            ])
            ->innerJoin(
                ['r' => StudentRegister::tableName()],
                'r.student_id = s.id AND r.semester_id = :sid',
                [':sid' => $semesterId]
            )
            ->leftJoin(['u' => \common\models\User::tableName()], 'u.id = s.user_id')
            ->orderBy(['s.matric_no' => SORT_ASC]);

        foreach ($query->asArray()->each(500) as $row) {
            $matric = isset($row['matric_no']) ? (string)$row['matric_no'] : '';
            if (trim($matric) === '') {
                continue;
            }

            $studentName = isset($row['student_name']) ? trim((string)$row['student_name']) : '';
            $statusDaftarText = StudentRegister::statusDaftarText($row['status_daftar'] ?? null);

            fputcsv($fp, [$matric, $studentName, $statusDaftarText]);
        }

        rewind($fp);
        return Yii::$app->response->sendStreamAsFile($fp, $filename, [
            'mimeType' => 'text/csv',
            'inline' => false,
        ]);
    }

    private function processCsv($path, $apply, $semesterId)
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
                if (!empty($header) && is_string($header[0])) {
                    $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
                }
                $cols = array_flip($header);

                // Accept both student_id (preferred) and legacy "student id"
                if (isset($cols['student_id'])) {
                    $studentIdKey = 'student_id';
                } elseif (isset($cols['student id'])) {
                    $studentIdKey = 'student id';
                }

                $required = ['status_daftar'];
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
            'semester_id' => (int)$semesterId,
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
                if (!empty($header) && is_string($header[0])) {
                    $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
                }
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
            $statusAktifText = '';

            if ($studentId === '') {
                $stats['skipped']++;
                continue;
            }

            $mappedDaftar = StudentRegister::mapStatusDaftarFromText($statusDaftarText);

            // status_aktif is auto-derived from status_daftar (never N/A)
            // Daftar / NOS => Aktif, otherwise => Tidak Aktif
            $mappedAktif = StudentRegister::STATUS_AKTIF_TIDAK_AKTIF;
            if ($mappedDaftar === StudentRegister::STATUS_DAFTAR_DAFTAR || $mappedDaftar === StudentRegister::STATUS_DAFTAR_NOS) {
                $mappedAktif = StudentRegister::STATUS_AKTIF_AKTIF;
            }

            if ($mappedDaftar === false) {
                $stats['invalid_status']++;
                $resultCounts['INVALID_STATUS']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_aktif_text' => StudentRegister::statusAktifText($mappedAktif),
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
                    'status_aktif_text' => StudentRegister::statusAktifText($mappedAktif),
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

            $reg = StudentRegister::find()->where([
                'student_id' => (int)$student->id,
                'semester_id' => (int)$semesterId,
            ])->one();

            $beforeDaftar = $reg ? $reg->status_daftar : null;
            $beforeAktif = $reg ? $reg->status_aktif : null;

            $tmpCur = new StudentRegister();
            $tmpCur->status_daftar = $beforeDaftar;
            $tmpCur->status_aktif = $beforeAktif;
            $currentDaftarText = $tmpCur->statusDaftarText;
            $currentAktifText = $tmpCur->statusAktifText;

            $daftarChanged = ($mappedDaftar !== null) && ((int)$beforeDaftar !== (int)$mappedDaftar);
            // Important: (int)null === 0, so we must treat NULL as different from 0
            if ($beforeAktif === null) {
                $aktifChanged = true;
            } else {
                $aktifChanged = ((int)$beforeAktif !== (int)$mappedAktif);
            }

            $changed = false;
            if ($daftarChanged) {
                $changed = true;
            }
            if ($aktifChanged) {
                $changed = true;
            }

            if (!$changed) {
                $stats['skipped']++;
                $resultCounts['NO_CHANGES']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_aktif_text' => StudentRegister::statusAktifText($mappedAktif),
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
                if (!$reg) {
                    $reg = new StudentRegister();
                    $reg->student_id = (int)$student->id;
                    $reg->semester_id = (int)$semesterId;
                }

                if ($daftarChanged) {
                    $reg->status_daftar = $mappedDaftar;
                }
                if ($aktifChanged) {
                    $reg->status_aktif = $mappedAktif;
                }

                $reg->scenario = 'csv_status';
                if ($reg->save()) {
                    $stats['updated']++;
                    $resultCounts['UPDATED']++;
                    $preview[] = [
                        'student_id' => $studentId,
                        'status_daftar_text' => $statusDaftarText,
                        'status_aktif_text' => StudentRegister::statusAktifText($mappedAktif),
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
                        'status_aktif_text' => StudentRegister::statusAktifText($mappedAktif),
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
                    'status_aktif_text' => StudentRegister::statusAktifText($mappedAktif),
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
