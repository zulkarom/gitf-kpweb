<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentCsvUploadForm;
use backend\modules\postgrad\models\StudentRegister;
use common\models\User;
use common\models\Common;
use common\models\Country;
use backend\modules\esiap\models\Program;
use backend\models\Campus;
use backend\models\Semester;
use yii\helpers\StringHelper;

class StudentCsvImportController extends Controller
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
        $model = new StudentCsvUploadForm();

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
                $map = Yii::$app->session->get('postgrad_student_csv_tokens', []);
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

    private function processCsv($path, $apply, $semesterId)
    {
        set_time_limit(0);

        $semesterId = (int)$semesterId;
        if (!$semesterId) {
            $currentSem = Semester::getCurrentSemester();
            if (!$currentSem) {
                return [[], ['error' => 'Current semester not found']];
            }
            $semesterId = (int)$currentSem->id;
        }

        $handle = $this->openCsvHandle($path);
        if (!$handle) {
            return [[], ['error' => 'Unable to open uploaded CSV file']];
        }

        $row = 0;
        $header = [];
        $cols = [];
        $studentIdKey = null;
        $statusDaftarKey = null;

        $stats = [
            'processed' => 0,
            'updated' => 0,
            'no_changes' => 0,
            'not_found' => 0,
            'invalid' => 0,
            'errors' => 0,
            'applied' => $apply ? 1 : 0,
            'semester_id' => $semesterId,
        ];

        $resultCounts = [
            'READY' => 0,
            'NO_CHANGES' => 0,
            'NOT_FOUND' => 0,
            'INVALID' => 0,
            'UPDATED' => 0,
            'FAILED' => 0,
        ];

        $preview = [];

        while (($data = fgetcsv($handle)) !== false) {
            $row++;

            if ($row === 1) {
                $header = array_map([$this, 'normalizeHeader'], $data);
                $cols = array_flip($header);

                $studentIdKey = $this->pickFirstExistingKey($cols, [
                    'student_id',
                    'student id',
                    'no. matrik',
                    'no matrik',
                    'no_matrik',
                    'matric no',
                    'matric_no',
                    'no.matrik',
                ]);

                $statusDaftarKey = $this->pickFirstExistingKey($cols, [
                    'status_daftar',
                    'status daftar',
                ]);

                if ($studentIdKey === null) {
                    fclose($handle);
                    return [[], ['error' => 'Missing required column: student_id']];
                }
                if ($statusDaftarKey === null) {
                    fclose($handle);
                    return [[], ['error' => 'Missing required column: status_daftar']];
                }

                continue;
            }

            $studentId = trim((string)$this->getValue($data, $cols, $studentIdKey));
            $statusDaftarText = trim((string)$this->getValue($data, $cols, $statusDaftarKey));

            if ($studentId === '' || $statusDaftarText === '') {
                $stats['invalid']++;
                $resultCounts['INVALID']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'result' => 'INVALID',
                    'message' => 'Missing student_id or status_daftar',
                ];
                continue;
            }

            $mappedDaftar = StudentRegister::mapStatusDaftarFromText($statusDaftarText);
            if ($mappedDaftar === false || $mappedDaftar === null) {
                $stats['invalid']++;
                $resultCounts['INVALID']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_daftar' => $mappedDaftar,
                    'status_aktif' => null,
                    'result' => 'INVALID',
                    'message' => 'Invalid status_daftar',
                ];
                continue;
            }

            $mappedAktif = in_array((int)$mappedDaftar, [StudentRegister::STATUS_DAFTAR_DAFTAR, StudentRegister::STATUS_DAFTAR_NOS], true)
                ? StudentRegister::STATUS_AKTIF_AKTIF
                : StudentRegister::STATUS_AKTIF_TIDAK_AKTIF;

            $student = Student::find()->where(['matric_no' => $studentId])->one();
            if (!$student) {
                $stats['not_found']++;
                $resultCounts['NOT_FOUND']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_daftar' => (int)$mappedDaftar,
                    'status_aktif' => (int)$mappedAktif,
                    'result' => 'NOT_FOUND',
                    'message' => 'Student not found',
                ];
                continue;
            }

            $reg = StudentRegister::find()->where([
                'student_id' => (int)$student->id,
                'semester_id' => $semesterId,
            ])->one();

            $beforeDaftar = $reg ? $reg->status_daftar : null;
            $beforeAktif = $reg ? $reg->status_aktif : null;

            $daftarChanged = ((int)$beforeDaftar !== (int)$mappedDaftar);
            $aktifChanged = ((int)$beforeAktif !== (int)$mappedAktif);
            $changed = $daftarChanged || $aktifChanged;

            $stats['processed']++;

            if (!$apply) {
                $resultCounts[$changed ? 'READY' : 'NO_CHANGES']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_daftar' => (int)$mappedDaftar,
                    'status_aktif' => (int)$mappedAktif,
                    'current_status_daftar' => $beforeDaftar,
                    'current_status_aktif' => $beforeAktif,
                    'result' => $changed ? 'READY' : 'NO_CHANGES',
                    'message' => $changed ? 'Will be updated' : 'No changes',
                ];
                continue;
            }

            if (!$changed) {
                $stats['no_changes']++;
                $resultCounts['NO_CHANGES']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_daftar' => (int)$mappedDaftar,
                    'status_aktif' => (int)$mappedAktif,
                    'current_status_daftar' => $beforeDaftar,
                    'current_status_aktif' => $beforeAktif,
                    'result' => 'NO_CHANGES',
                    'message' => 'No changes',
                ];
                continue;
            }

            $tx = Yii::$app->db->beginTransaction();
            try {
                if (!$reg) {
                    $reg = new StudentRegister();
                    $reg->student_id = (int)$student->id;
                    $reg->semester_id = $semesterId;
                }

                $reg->scenario = 'csv_status';
                $reg->status_daftar = (int)$mappedDaftar;
                $reg->status_aktif = (int)$mappedAktif;

                if (!$reg->save(false)) {
                    throw new \RuntimeException('Failed to save student register');
                }

                $tx->commit();
                $stats['updated']++;
                $resultCounts['UPDATED']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_daftar' => (int)$mappedDaftar,
                    'status_aktif' => (int)$mappedAktif,
                    'current_status_daftar' => $beforeDaftar,
                    'current_status_aktif' => $beforeAktif,
                    'result' => 'UPDATED',
                    'message' => 'Updated',
                ];
            } catch (\Throwable $e) {
                $tx->rollBack();
                $stats['errors']++;
                $resultCounts['FAILED']++;
                $preview[] = [
                    'student_id' => $studentId,
                    'status_daftar_text' => $statusDaftarText,
                    'status_daftar' => (int)$mappedDaftar,
                    'status_aktif' => (int)$mappedAktif,
                    'result' => 'FAILED',
                    'message' => StringHelper::truncate((string)$e->getMessage(), 180),
                ];
            }
        }

        fclose($handle);

        $stats['result_counts'] = $resultCounts;

        return [$preview, $stats];
    }

    private function ensureUser($matric, $name, $email)
    {
        $user = User::find()->where(['username' => $matric])->one();
        if ($user) {
            return $user;
        }

        $user = new User();
        $user->username = $matric;
        $random = (string)random_int(100000, 999999);
        $user->password_hash = Yii::$app->security->generatePasswordHash($random);
        $user->email = $email !== '' ? $email : ($matric . '@example.local');
        $user->fullname = $name !== '' ? $name : $matric;
        $user->status = 10;
        $user->save(false);

        return $user;
    }

    private function inferProgramId(array $data, array $cols, $programCodeFromCsv = '')
    {
        $programIdKey = $this->pickFirstExistingKey($cols, ['program_id']);
        if ($programIdKey !== null) {
            $val = trim((string)$this->getValue($data, $cols, $programIdKey));
            return is_numeric($val) ? (int)$val : null;
        }

        $code = trim((string)$programCodeFromCsv);
        if ($code === '') {
            return null;
        }

        $program = Program::find()->where(['program_code' => $code])->one();
        if ($program) {
            return (int)$program->id;
        }

        return null;
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

    private function normalizeHeader($val)
    {
        $v = trim((string)$val);
        $v = ltrim($v, "\xEF\xBB\xBF");
        $v = str_replace(["\u{200B}"], '', $v);
        $v = mb_strtolower($v);
        $v = preg_replace('/\s+/', ' ', $v);
        return trim($v);
    }

    private function parseDate($val)
    {
        $v = trim((string)$val);
        if ($v === '') {
            return null;
        }

        $ts = strtotime($v);
        if ($ts === false) {
            return null;
        }

        return date('Y-m-d', $ts);
    }

    private function mapGender($text)
    {
        $t = mb_strtolower(trim((string)$text));
        if ($t === '') {
            return null;
        }
        if (strpos($t, 'lelaki') !== false || strpos($t, 'male') !== false) {
            return 1;
        }
        if (strpos($t, 'perempuan') !== false || strpos($t, 'female') !== false) {
            return 0;
        }
        return null;
    }

    private function mapMaritalStatus($text)
    {
        $t = mb_strtolower(trim((string)$text));
        if ($t === '') {
            return null;
        }

        $map = Common::marital2();
        foreach ($map as $k => $v) {
            if (mb_strtolower($v) === $t) {
                return (int)$k;
            }
        }

        return null;
    }

    private function mapCitizenship($text)
    {
        $t = mb_strtolower(trim((string)$text));
        if ($t === '') {
            return null;
        }
        if ($t === 'tempatan' || $t === 'local') {
            return 1;
        }
        if ($t === 'antarabangsa' || $t === 'international') {
            return 2;
        }
        return null;
    }

    private function mapNationality($text)
    {
        $t = trim((string)$text);
        if ($t === '') {
            return null;
        }

        $country = Country::find()->where(['name' => $t])->one();
        if ($country) {
            return (int)$country->id;
        }

        $country = Country::find()->where(['like', 'name', $t])->one();
        if ($country) {
            return (int)$country->id;
        }

        return null;
    }

    private function mapStudyMode($text)
    {
        $t = mb_strtolower(trim((string)$text));
        if ($t === '') {
            return null;
        }
        if (strpos($t, 'sepenuh') !== false || strpos($t, 'full') !== false) {
            return 1;
        }
        if (strpos($t, 'separuh') !== false || strpos($t, 'part') !== false) {
            return 2;
        }
        return null;
    }

    private function mapCampus($text)
    {
        $t = trim((string)$text);
        if ($t === '') {
            return null;
        }

        $campus = Campus::find()->where(['campus_name' => $t])->one();
        if ($campus) {
            return (int)$campus->id;
        }

        $campus = Campus::find()->where(['like', 'campus_name', $t])->one();
        if ($campus) {
            return (int)$campus->id;
        }

        return null;
    }

    private function pickFirstExistingKey(array $cols, array $candidates)
    {
        foreach ($candidates as $c) {
            $key = $this->normalizeHeader($c);
            if (isset($cols[$key])) {
                return $key;
            }
        }
        return null;
    }

    private function getValue(array $data, array $cols, $key)
    {
        if ($key === null) {
            return null;
        }
        $idx = $cols[$key] ?? null;
        if ($idx === null) {
            return null;
        }
        return isset($data[$idx]) ? $data[$idx] : null;
    }
}
