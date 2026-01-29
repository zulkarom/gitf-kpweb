<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentCsvUploadForm;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\postgrad\models\Field;
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

        $preview = null;
        $summary = null;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->load($post);

            $selected = Yii::$app->request->post('selected', []);
            if (!is_array($selected)) {
                $selected = [];
            }

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
                    [$preview, $summary] = $this->processCsv($path, false, $selected);

                    $applyIntent = (string)Yii::$app->request->post('apply_intent', '0');
                    $applyIntent = trim($applyIntent);

                    if ($applyIntent === '1') {
                        [$preview, $summary] = $this->processCsv($path, true, $selected);
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

    private function processCsv($path, $apply, array $selected = [])
    {
        set_time_limit(0);

        $handle = $this->openCsvHandle($path);
        if (!$handle) {
            return [[], ['error' => 'Unable to open uploaded CSV file']];
        }

        $row = 0;
        $header = [];
        $headerMap = [];

        $stats = [
            'processed' => 0,
            'updated' => 0,
            'created' => 0,
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
                $header = array_map([$this, 'normalizeHeaderForMatch'], $data);
                $headerMap = $this->mapHeadersByKeywords($header);

                $missing = [];
                foreach ($this->getRequiredTargets() as $req) {
                    if (!isset($headerMap[$req]) || $headerMap[$req] === null) {
                        $missing[] = $req;
                    }
                }
                if (!empty($missing)) {
                    fclose($handle);
                    return [[], ['error' => 'Missing required column(s): ' . implode(', ', $missing)]];
                }

                continue;
            }

            $matric = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'matric_no'));
            $name = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'name'));
            $emailStudent = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'email_student'));
            $nricRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'nric'));
            $citizenshipRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'citizenship'));
            $programRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'program'));
            $studyModeRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'study_mode'));

            $addressRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'address'));
            $cityRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'city'));
            $phoneRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'phone_no'));
            $personalEmailRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'personal_email'));
            $nationalityRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'nationality'));
            $genderRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'gender'));
            $maritalRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'marital_status'));
            $dobRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'date_birth'));
            $fieldRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'field'));
            $campusRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'campus'));
            $sponsorRaw = $this->normalizeCellValue($this->getMappedValue($data, $headerMap, 'sponsor'));

            $missingFields = [];
            if ($matric === '') { $missingFields[] = 'MATRIK'; }
            if ($name === '') { $missingFields[] = 'NAMA PELAJAR'; }
            if ($nricRaw === '') { $missingFields[] = 'NO. IC'; }
            if ($citizenshipRaw === '') { $missingFields[] = 'KEWARGANEGARAAN'; }
            if ($programRaw === '') { $missingFields[] = 'PROGRAM'; }
            if ($studyModeRaw === '') { $missingFields[] = 'TARAF PENGAJIAN'; }
            if ($emailStudent === '') { $missingFields[] = 'EMEL PELAJAR'; }

            if (!empty($missingFields)) {
                $stats['invalid']++;
                $resultCounts['INVALID']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'name' => $name,
                    'email' => $emailStudent,
                    'result' => 'INVALID',
                    'message' => 'Missing required field(s): ' . implode(', ', $missingFields),
                ];
                continue;
            }

            $mappedCitizenship = $this->mapCitizenship($citizenshipRaw);
            $mappedStudyMode = $this->mapStudyMode($studyModeRaw);
            $nric = str_replace('-', '', (string)$nricRaw);
            $programId = $this->mapProgramIdFromText($programRaw);

            $mappedNationality = null;
            if ($nationalityRaw !== '') {
                $mappedNationality = $this->mapNationality($nationalityRaw);
            }

            $mappedGender = null;
            if ($genderRaw !== '') {
                $mappedGender = $this->mapGender($genderRaw);
            }

            $mappedMarital = null;
            if ($maritalRaw !== '') {
                $mappedMarital = $this->mapMaritalStatus($maritalRaw);
            }

            $mappedDob = null;
            if ($dobRaw !== '') {
                $mappedDob = $this->parseDate($dobRaw);
            }

            $mappedFieldId = null;
            if ($fieldRaw !== '') {
                $mappedFieldId = $this->mapFieldIdFromText($fieldRaw);
            }

            $mappedCampusId = null;
            if ($campusRaw !== '') {
                $mappedCampusId = $this->mapCampus($campusRaw);
            }

            if ($mappedCitizenship === null || $mappedStudyMode === null || !$programId) {
                $stats['invalid']++;
                $resultCounts['INVALID']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'name' => $name,
                    'email' => $emailStudent,
                    'result' => 'INVALID',
                    'message' => 'Invalid required value(s) (citizenship/program/study mode)',
                ];
                continue;
            }

            $student = Student::find()->where(['matric_no' => $matric])->one();
            if (!$student) {
                if (!$apply) {
                    $stats['not_found']++;
                    $resultCounts['NOT_FOUND']++;
                    $preview[] = [
                        'matric_no' => $matric,
                        'name' => $name,
                        'email' => $emailStudent,
                        'result' => 'NOT_FOUND',
                        'message' => 'NEW STUDENT TO BE CREATED',
                    ];
                    continue;
                }

                $tx = Yii::$app->db->beginTransaction();
                try {
                    $user = $this->ensureUser($matric, $name, $emailStudent);

                    $student = new Student();
                    $student->user_id = (int)$user->id;
                    $student->matric_no = $matric;
                    $student->nric = $nric;
                    $student->citizenship = (int)$mappedCitizenship;
                    $student->program_id = (int)$programId;
                    $student->study_mode = (int)$mappedStudyMode;

                    if ($addressRaw !== '') {
                        $student->address = $addressRaw;
                    }
                    if ($cityRaw !== '') {
                        $student->city = $cityRaw;
                    }
                    if ($phoneRaw !== '') {
                        $student->phone_no = $phoneRaw;
                    }
                    if ($personalEmailRaw !== '') {
                        $student->personal_email = $personalEmailRaw;
                    }
                    if ($mappedNationality !== null) {
                        $student->nationality = (int)$mappedNationality;
                    }
                    if ($mappedGender !== null) {
                        $student->gender = (int)$mappedGender;
                    }
                    if ($mappedMarital !== null) {
                        $student->marital_status = (int)$mappedMarital;
                    }
                    if ($mappedDob !== null) {
                        $student->date_birth = (string)$mappedDob;
                    }
                    if ($mappedFieldId !== null) {
                        $student->field_id = (int)$mappedFieldId;
                    }
                    if ($mappedCampusId !== null) {
                        $student->campus_id = (int)$mappedCampusId;
                    }
                    if ($sponsorRaw !== '') {
                        $student->sponsor = $sponsorRaw;
                    }

                    $now = time();
                    if ($student->hasAttribute('created_at')) {
                        $student->created_at = $now;
                    }
                    if ($student->hasAttribute('updated_at')) {
                        $student->updated_at = $now;
                    }

                    if (!$student->save(false)) {
                        throw new \RuntimeException('Failed to create student');
                    }

                    $tx->commit();
                    $stats['processed']++;
                    $stats['created']++;
                    $resultCounts['CREATED']++;
                    $preview[] = [
                        'matric_no' => $matric,
                        'name' => $name,
                        'email' => $emailStudent,
                        'result' => 'CREATED',
                        'message' => 'Created',
                        'changes' => $this->diffAssoc([], [
                            'student_nric' => $nric,
                            'student_citizenship' => (int)$mappedCitizenship,
                            'student_program_id' => (int)$programId,
                            'student_study_mode' => (int)$mappedStudyMode,
                            'student_address' => $addressRaw !== '' ? $addressRaw : null,
                            'student_city' => $cityRaw !== '' ? $cityRaw : null,
                            'student_phone_no' => $phoneRaw !== '' ? $phoneRaw : null,
                            'student_personal_email' => $personalEmailRaw !== '' ? $personalEmailRaw : null,
                            'student_nationality' => $mappedNationality !== null ? (int)$mappedNationality : null,
                            'student_gender' => $mappedGender !== null ? (int)$mappedGender : null,
                            'student_marital_status' => $mappedMarital !== null ? (int)$mappedMarital : null,
                            'student_date_birth' => $mappedDob !== null ? (string)$mappedDob : null,
                            'student_field_id' => $mappedFieldId !== null ? (int)$mappedFieldId : null,
                            'student_campus_id' => $mappedCampusId !== null ? (int)$mappedCampusId : null,
                            'student_sponsor' => $sponsorRaw !== '' ? $sponsorRaw : null,
                            'user_fullname' => $name,
                            'user_email' => $emailStudent,
                        ]),
                    ];
                } catch (\Throwable $e) {
                    $tx->rollBack();
                    $stats['errors']++;
                    $resultCounts['FAILED']++;
                    $preview[] = [
                        'matric_no' => $matric,
                        'name' => $name,
                        'email' => $emailStudent,
                        'result' => 'FAILED',
                        'message' => StringHelper::truncate((string)$e->getMessage(), 180),
                    ];
                }

                continue;
            }

            $user = $student->user;
            if (!$user) {
                $user = User::find()->where(['username' => $matric])->one();
            }

            $before = [
                'student_nric' => $this->normalizeCellValue((string)$student->nric),
                'student_citizenship' => (int)$student->citizenship,
                'student_program_id' => (int)$student->program_id,
                'student_study_mode' => (int)$student->study_mode,
                'student_address' => $this->normalizeCellValue((string)$student->address),
                'student_city' => $this->normalizeCellValue((string)$student->city),
                'student_phone_no' => $this->normalizeCellValue((string)$student->phone_no),
                'student_personal_email' => $this->normalizeCellValue((string)$student->personal_email),
                'student_nationality' => (int)$student->nationality,
                'student_gender' => (int)$student->gender,
                'student_marital_status' => (int)$student->marital_status,
                'student_date_birth' => $this->normalizeCellValue((string)$student->date_birth),
                'student_field_id' => (int)$student->field_id,
                'student_campus_id' => (int)$student->campus_id,
                'student_sponsor' => $this->normalizeCellValue((string)$student->sponsor),
                'user_fullname' => $this->normalizeCellValue($user ? (string)$user->fullname : ''),
                'user_email' => $this->normalizeCellValue($user ? (string)$user->email : ''),
            ];

            $after = $before;

            if (!$this->isExcelScientificNotation($nric) && !$this->isExcelScientificNotation($nricRaw)) {
                $after['student_nric'] = $nric;
            }
            $after['student_citizenship'] = (int)$mappedCitizenship;
            $after['student_program_id'] = (int)$programId;
            $after['student_study_mode'] = (int)$mappedStudyMode;

            if ($addressRaw !== '') {
                $after['student_address'] = $addressRaw;
            }
            if ($cityRaw !== '') {
                $after['student_city'] = $cityRaw;
            }
            if ($phoneRaw !== '' && !$this->isExcelScientificNotation($phoneRaw)) {
                if (!$this->isPhoneOnlyLeadingZeroRemoved($before['student_phone_no'], $phoneRaw)) {
                    $after['student_phone_no'] = $phoneRaw;
                }
            }
            if ($personalEmailRaw !== '') {
                $after['student_personal_email'] = $personalEmailRaw;
            }
            if ($mappedNationality !== null) {
                $after['student_nationality'] = (int)$mappedNationality;
            }
            if ($mappedGender !== null) {
                $after['student_gender'] = (int)$mappedGender;
            }
            if ($mappedMarital !== null) {
                $after['student_marital_status'] = (int)$mappedMarital;
            }
            if ($mappedDob !== null) {
                $oldYear = $this->extractYear($before['student_date_birth']);
                $newYear = $this->extractYear($mappedDob);
                if ($oldYear === null || $newYear === null || $oldYear !== $newYear) {
                    $after['student_date_birth'] = (string)$mappedDob;
                }
            }
            if ($mappedFieldId !== null) {
                $after['student_field_id'] = (int)$mappedFieldId;
            }
            if ($mappedCampusId !== null) {
                $after['student_campus_id'] = (int)$mappedCampusId;
            }
            if ($sponsorRaw !== '') {
                $after['student_sponsor'] = $sponsorRaw;
            }

            $after['user_fullname'] = $name;
            $after['user_email'] = $emailStudent;

            $matricKey = (string)$matric;
            if (!empty($selected) && isset($selected[$matricKey]) && is_array($selected[$matricKey])) {
                $sel = $selected[$matricKey];
                foreach ($after as $k => $v) {
                    $isChecked = isset($sel[$k]) && (string)$sel[$k] === '1';
                    if (!$isChecked) {
                        $after[$k] = $before[$k] ?? null;
                    }
                }
            }

            $changed = ($before != $after);
            $diff = $this->diffAssoc($before, $after);
            $stats['processed']++;

            if (!$apply) {
                $resultCounts[$changed ? 'READY' : 'NO_CHANGES']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'name' => $name,
                    'email' => $emailStudent,
                    'result' => $changed ? 'READY' : 'NO_CHANGES',
                    'message' => $changed ? 'Will be updated' : 'No changes',
                    'changes' => $diff,
                ];
                continue;
            }

            if (!$changed) {
                $stats['no_changes']++;
                $resultCounts['NO_CHANGES']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'name' => $name,
                    'email' => $emailStudent,
                    'result' => 'NO_CHANGES',
                    'message' => 'No changes',
                    'changes' => $diff,
                ];
                continue;
            }

            $tx = Yii::$app->db->beginTransaction();
            try {
                if (!$user) {
                    $user = $this->ensureUser($matric, $name, $emailStudent);
                    $student->user_id = (int)$user->id;
                } else {
                    if ($after['user_fullname'] !== $before['user_fullname']) {
                        $user->fullname = (string)$after['user_fullname'];
                    }
                    if ($after['user_email'] !== $before['user_email']) {
                        $user->email = (string)$after['user_email'];
                    }
                    $user->status = 10;
                    if (!$user->save(false)) {
                        throw new \RuntimeException('Failed to save user');
                    }
                }

                if ($after['student_nric'] !== $before['student_nric']) {
                    $student->nric = (string)$after['student_nric'];
                }
                if ($after['student_citizenship'] !== $before['student_citizenship']) {
                    $student->citizenship = (int)$after['student_citizenship'];
                }
                if ($after['student_program_id'] !== $before['student_program_id']) {
                    $student->program_id = (int)$after['student_program_id'];
                }
                if ($after['student_study_mode'] !== $before['student_study_mode']) {
                    $student->study_mode = (int)$after['student_study_mode'];
                }

                if ($after['student_address'] !== $before['student_address']) {
                    $student->address = (string)$after['student_address'];
                }
                if ($after['student_city'] !== $before['student_city']) {
                    $student->city = (string)$after['student_city'];
                }
                if ($after['student_phone_no'] !== $before['student_phone_no']) {
                    $student->phone_no = (string)$after['student_phone_no'];
                }
                if ($after['student_personal_email'] !== $before['student_personal_email']) {
                    $student->personal_email = (string)$after['student_personal_email'];
                }
                if ($after['student_nationality'] !== $before['student_nationality']) {
                    $student->nationality = (int)$after['student_nationality'];
                }
                if ($after['student_gender'] !== $before['student_gender']) {
                    $student->gender = (int)$after['student_gender'];
                }
                if ($after['student_marital_status'] !== $before['student_marital_status']) {
                    $student->marital_status = (int)$after['student_marital_status'];
                }
                if ($after['student_date_birth'] !== $before['student_date_birth']) {
                    $student->date_birth = (string)$after['student_date_birth'];
                }
                if ($after['student_field_id'] !== $before['student_field_id']) {
                    $student->field_id = (int)$after['student_field_id'];
                }
                if ($after['student_campus_id'] !== $before['student_campus_id']) {
                    $student->campus_id = (int)$after['student_campus_id'];
                }
                if ($after['student_sponsor'] !== $before['student_sponsor']) {
                    $student->sponsor = (string)$after['student_sponsor'];
                }

                $student->updated_at = time();

                if (!$student->save(false)) {
                    throw new \RuntimeException('Failed to save student');
                }

                $tx->commit();
                $stats['updated']++;
                $resultCounts['UPDATED']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'name' => $name,
                    'email' => $emailStudent,
                    'result' => 'UPDATED',
                    'message' => 'Updated',
                    'changes' => $diff,
                ];
            } catch (\Throwable $e) {
                $tx->rollBack();
                $stats['errors']++;
                $resultCounts['FAILED']++;
                $preview[] = [
                    'matric_no' => $matric,
                    'name' => $name,
                    'email' => $emailStudent,
                    'result' => 'FAILED',
                    'message' => StringHelper::truncate((string)$e->getMessage(), 180),
                    'changes' => $diff,
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

    private function mapFieldIdFromText($text)
    {
        $t = trim((string)$text);
        if ($t === '') {
            return null;
        }

        $field = Field::find()->where(['LOWER([[field_name]])' => mb_strtolower($t, 'UTF-8')])->one();
        if ($field) {
            return (int)$field->id;
        }

        $field = Field::find()->where(['like', 'field_name', $t])->one();
        if ($field) {
            return (int)$field->id;
        }

        return null;
    }

    private function isExcelScientificNotation($val)
    {
        $v = trim((string)$val);
        if ($v === '') {
            return false;
        }

        if (preg_match('/^[+-]?(?:\d+(?:\.\d+)?|\.\d+)[eE][+-]?\d+$/', $v)) {
            return true;
        }

        return false;
    }

    private function isPhoneOnlyLeadingZeroRemoved($old, $new)
    {
        $o = preg_replace('/\D+/', '', (string)$old);
        $n = preg_replace('/\D+/', '', (string)$new);

        if ($o === '' || $n === '') {
            return false;
        }

        if ($o === $n) {
            return false;
        }

        if (preg_match('/^0+\d+$/', $o) && ltrim($o, '0') === $n) {
            return true;
        }

        return false;
    }

    private function extractYear($ymd)
    {
        $v = trim((string)$ymd);
        if ($v === '') {
            return null;
        }
        if (preg_match('/^(\d{4})-\d{2}-\d{2}$/', $v, $m)) {
            return (int)$m[1];
        }
        return null;
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

    private function normalizeHeaderForMatch($val)
    {
        $v = $this->normalizeHeader($val);
        $v = preg_replace('/[^\p{L}\p{N}]+/u', ' ', (string)$v);
        $v = preg_replace('/\s+/', ' ', (string)$v);
        return trim((string)$v);
    }

    private function getRequiredTargets()
    {
        return [
            'matric_no',
            'name',
            'nric',
            'citizenship',
            'program',
            'study_mode',
            'email_student',
        ];
    }

    private function headerKeywordMap()
    {
        return [
            'matric_no' => ['matrik', 'matric', 'no matrik', 'no. matrik'],
            'name' => ['nama pelajar', 'nama', 'name'],
            'nric' => ['no ic', 'no. ic', 'ic', 'passport'],
            'citizenship' => ['kewarganegaraan', 'citizenship'],
            'program' => ['program'],
            'study_mode' => ['taraf pengajian', 'mod pengajian', 'mode pengajian'],
            'email_student' => ['emel pelajar', 'student email', 'email pelajar'],

            'personal_email' => ['emel personal', 'personal email'],
            'phone_no' => ['no telefon', 'telefon', 'phone'],
            'address' => ['alamat', 'address'],
            'city' => ['daerah', 'city'],
            'nationality' => ['negara asal', 'negara', 'nationality'],
            'gender' => ['jantina', 'gender'],
            'marital_status' => ['taraf perkahwinan', 'kahwin', 'marital'],
            'date_birth' => ['tarikh lahir', 'date of birth', 'dob'],
            'field' => ['bidang pengajian', 'bidang'],
            'campus' => ['kampus', 'campus'],
            'sponsor' => ['pembiayaan', 'tajaan', 'pembiayaan sendiri'],
            'program_code' => ['kod program', 'program code'],
        ];
    }

    private function mapHeadersByKeywords(array $normalizedHeaders)
    {
        $map = [];
        $kwMap = $this->headerKeywordMap();

        foreach ($kwMap as $target => $keywords) {
            $bestIdx = null;
            $bestScore = -1;
            $ambiguous = false;

            foreach ($normalizedHeaders as $idx => $headerText) {
                foreach ($keywords as $kw) {
                    $nkw = $this->normalizeHeaderForMatch($kw);
                    if ($nkw === '') {
                        continue;
                    }
                    if (mb_strpos((string)$headerText, (string)$nkw) !== false) {
                        $score = mb_strlen((string)$nkw);
                        if ((string)$headerText === (string)$nkw) {
                            $score += 10000;
                        }
                        if ($score > $bestScore) {
                            $bestScore = $score;
                            $bestIdx = $idx;
                            $ambiguous = false;
                        } elseif ($score === $bestScore && $bestIdx !== null && $bestIdx !== $idx) {
                            $ambiguous = true;
                        }
                    }
                }
            }

            if ($ambiguous) {
                $map[$target] = null;
            } else {
                $map[$target] = $bestIdx;
            }
        }

        return $map;
    }

    private function getMappedValue(array $data, array $headerMap, $target)
    {
        if (!isset($headerMap[$target]) || $headerMap[$target] === null) {
            return null;
        }
        $idx = (int)$headerMap[$target];
        return isset($data[$idx]) ? $data[$idx] : null;
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

    private function mapProgramIdFromText($text)
    {
        $t = trim((string)$text);
        if ($t === '') {
            return null;
        }

        $lower = mb_strtolower($t, 'UTF-8');
        if (strpos($lower, 'sarjana') !== false && strpos($lower, 'doktor') === false) {
            return 84;
        }
        if (strpos($lower, 'doktor') !== false || strpos($lower, 'phd') !== false) {
            return 85;
        }

        if (is_numeric($t)) {
            return (int)$t;
        }

        $program = Program::find()->where(['pro_name' => $t])->one();
        if ($program) {
            return (int)$program->id;
        }

        $program = Program::find()->where(['like', 'pro_name', $t])->one();
        if ($program) {
            return (int)$program->id;
        }

        return null;
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

        $country = Country::find()->where(['country_name' => $t])->one();
        if ($country) {
            return (int)$country->id;
        }

        $country = Country::find()->where(['like', 'country_name', $t])->one();
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
