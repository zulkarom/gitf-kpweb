<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentCsvUploadForm;
use common\models\User;
use common\models\Common;
use common\models\Country;
use backend\modules\esiap\models\Program;
use backend\models\Campus;
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

        $preview = null;
        $summary = null;

        if (Yii::$app->request->isPost) {
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
        set_time_limit(0);

        $handle = $this->openCsvHandle($path);
        if (!$handle) {
            return [[], ['error' => 'Unable to open uploaded CSV file']];
        }

        $row = 0;
        $header = [];
        $cols = [];
        $matricKey = null;
        $nameKey = null;
        $emailKey = null;
        $nricKey = null;
        $dobKey = null;
        $genderKey = null;
        $maritalKey = null;
        $nationalityKey = null;
        $citizenshipKey = null;
        $studyModeKey = null;
        $campusKey = null;
        $programCodeKey = null;

        $stats = [
            'processed' => 0,
            'created' => 0,
            'skipped_exists' => 0,
            'skipped_invalid' => 0,
            'errors' => 0,
            'applied' => $apply ? 1 : 0,
        ];

        $resultCounts = [
            'READY' => 0,
            'EXISTS' => 0,
            'INVALID' => 0,
            'CREATED' => 0,
            'FAILED' => 0,
        ];

        $preview = [];

        while (($data = fgetcsv($handle)) !== false) {
            $row++;

            if ($row === 1) {
                $header = array_map([$this, 'normalizeHeader'], $data);
                $cols = array_flip($header);

                $matricKey = $this->pickFirstExistingKey($cols, [
                    'no. matrik',
                    'no matrik',
                    'no_matrik',
                    'matric no',
                    'matric_no',
                    'no.matrik',
                ]);

                $nameKey = $this->pickFirstExistingKey($cols, [
                    'nama pelajar',
                    'name',
                    'nama',
                ]);

                $emailKey = $this->pickFirstExistingKey($cols, [
                    'emel pelajar',
                    'email pelajar',
                    'email',
                    'emel',
                ]);

                $nricKey = $this->pickFirstExistingKey($cols, [
                    'no. ic / passport',
                    'no ic / passport',
                    'nric',
                    'no ic',
                ]);

                $dobKey = $this->pickFirstExistingKey($cols, [
                    'tarikh lahir',
                    'date_birth',
                    'date birth',
                ]);

                $genderKey = $this->pickFirstExistingKey($cols, [
                    'jantina',
                    'gender',
                ]);

                $maritalKey = $this->pickFirstExistingKey($cols, [
                    'taraf perkahwinan',
                    'marital status',
                ]);

                $nationalityKey = $this->pickFirstExistingKey($cols, [
                    'negara asal',
                    'negara',
                    'nationality',
                ]);

                $citizenshipKey = $this->pickFirstExistingKey($cols, [
                    'kewarganegaraan',
                    'citizenship',
                ]);

                $studyModeKey = $this->pickFirstExistingKey($cols, [
                    'mod pengajian',
                    'study mode',
                ]);

                $campusKey = $this->pickFirstExistingKey($cols, [
                    'kampus',
                    'campus',
                ]);

                $programCodeKey = $this->pickFirstExistingKey($cols, [
                    'kod program',
                    'program code',
                ]);

                if ($matricKey === null) {
                    fclose($handle);
                    return [[], ['error' => 'Missing required column: NO. MATRIK']];
                }

                continue;
            }

            $matric = $this->getValue($data, $cols, $matricKey);
            $matric = trim((string)$matric);

            $name = $nameKey !== null ? trim((string)$this->getValue($data, $cols, $nameKey)) : '';
            $email = $emailKey !== null ? trim((string)$this->getValue($data, $cols, $emailKey)) : '';

            $nric = $nricKey !== null ? trim((string)$this->getValue($data, $cols, $nricKey)) : '';
            $dobText = $dobKey !== null ? trim((string)$this->getValue($data, $cols, $dobKey)) : '';
            $genderText = $genderKey !== null ? trim((string)$this->getValue($data, $cols, $genderKey)) : '';
            $maritalText = $maritalKey !== null ? trim((string)$this->getValue($data, $cols, $maritalKey)) : '';
            $nationalityText = $nationalityKey !== null ? trim((string)$this->getValue($data, $cols, $nationalityKey)) : '';
            $citizenshipText = $citizenshipKey !== null ? trim((string)$this->getValue($data, $cols, $citizenshipKey)) : '';
            $studyModeText = $studyModeKey !== null ? trim((string)$this->getValue($data, $cols, $studyModeKey)) : '';
            $campusText = $campusKey !== null ? trim((string)$this->getValue($data, $cols, $campusKey)) : '';
            $programCode = $programCodeKey !== null ? trim((string)$this->getValue($data, $cols, $programCodeKey)) : '';

            if ($matric === '') {
                $stats['skipped_invalid']++;
                $resultCounts['INVALID']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'name' => $name,
                    'email' => $email,
                    'result' => 'INVALID',
                    'message' => 'Empty matric number',
                ];
                continue;
            }

            $existing = Student::find()->where(['matric_no' => $matric])->exists();
            if ($existing) {
                $stats['skipped_exists']++;
                $resultCounts['EXISTS']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'name' => $name,
                    'email' => $email,
                    'result' => 'EXISTS',
                    'message' => 'Already exists',
                ];
                continue;
            }

            $stats['processed']++;

            if (!$apply) {
                $resultCounts['READY']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'name' => $name,
                    'email' => $email,
                    'result' => 'READY',
                    'message' => 'Will be created',
                ];
                continue;
            }

            $tx = Yii::$app->db->beginTransaction();
            try {
                $user = $this->ensureUser($matric, $name, $email);

                $student = new Student();
                $student->scenario = 'create';
                $student->user_id = $user->id;
                $student->matric_no = $matric;

                $student->program_id = $this->inferProgramId($data, $cols, $programCode);
                if (!$student->program_id) {
                    $stats['skipped_invalid']++;
                    $resultCounts['INVALID']++;
                    $preview[] = [
                        'matric_no' => $matric,
                        'name' => $name,
                        'email' => $email,
                        'result' => 'INVALID',
                        'message' => 'Missing/unknown program id',
                    ];
                    $tx->rollBack();
                    continue;
                }

                $student->name = $name !== '' ? $name : $matric;
                $student->personal_email = $email !== '' ? $email : null;
                $student->nric = $nric !== '' ? $nric : null;

                $student->date_birth = $this->parseDate($dobText);
                $student->gender = $this->mapGender($genderText);
                $student->marital_status = $this->mapMaritalStatus($maritalText);
                $student->nationality = $this->mapNationality($nationalityText);
                $student->citizenship = $this->mapCitizenship($citizenshipText);
                $student->study_mode = $this->mapStudyMode($studyModeText);
                $student->campus_id = $this->mapCampus($campusText);

                if (!$student->save(false)) {
                    throw new \RuntimeException('Failed to save student');
                }

                $tx->commit();

                $stats['created']++;
                $resultCounts['CREATED']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'name' => $name,
                    'email' => $email,
                    'result' => 'CREATED',
                    'message' => 'Created',
                ];
            } catch (\Throwable $e) {
                $tx->rollBack();
                $stats['errors']++;
                $resultCounts['FAILED']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'name' => $name,
                    'email' => $email,
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
