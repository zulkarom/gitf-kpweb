<?php

namespace backend\modules\postgrad\models;

use Yii;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\postgrad\models\Field;
use backend\modules\postgrad\models\StudentSupervisor;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\StudentData;
use backend\models\Campus;
use backend\models\Semester;
use common\models\User;
use common\models\Country;
use common\models\Common;
use student\models\StudentData as SrcStudentData;

class StudentDataImportCsv
{

    public function importFromSource($limit = 50)
    {
        $createdUsers = 0;
        $updatedUsers = 0;
        $createdStudents = 0;
        $updatedStudents = 0;
        $errors = [];

        $srcRows = SrcStudentData::find()->where(['DONE' => 0])->limit((int)$limit)->all();
        foreach ($srcRows as $stud) {
            $tx = Yii::$app->db->beginTransaction();
            try {
                $username = trim((string)$stud->NO_MATRIK);
                if ($username === '') {
                    throw new \RuntimeException('Missing NO_MATRIK');
                }

                $user = User::find()
                    ->where(['email' => $stud->EMEL_PELAJAR])
                    ->orWhere(['username' => $username])
                    ->one();

                if (!$user) {
                    $user = new User();
                    $user->username = $username;
                    $random = (string)random_int(100000, 999999);
                    $user->password_hash = Yii::$app->security->generatePasswordHash($random);
                    $user->email = $stud->EMEL_PELAJAR ?: ($username . '@example.local');
                    $user->fullname = $stud->NAMA_PELAJAR ?: $username;
                    $user->status = 10;
                    if (!$user->save(false)) {
                        throw new \RuntimeException('Failed saving new User');
                    }
                    $createdUsers++;
                } else {
                    $user->email = $stud->EMEL_PELAJAR ?: $user->email;
                    $user->username = $username;
                    $user->fullname = $stud->NAMA_PELAJAR ?: $user->fullname;
                    $user->status = 10;
                    $user->save(false);
                    $updatedUsers++;
                }

                $student = Student::find()->where(['matric_no' => $username])->one();
                if (!$student) {
                    $student = new Student();
                }
                $isNew = $student->isNewRecord;

                $student->user_id = $this->mapUserId($user);
                $student->matric_no = $this->mapMatricNo($stud);
                $student->nric = $this->mapNric($stud);
                $student->date_birth = $this->mapDateBirth($stud);
                $student->marital_status = $this->mapMaritalStatus($stud);
                $student->gender = $this->mapGender($stud);
                $student->nationality = $this->mapNationality($stud);
                $student->citizenship = $this->mapCitizenship($stud);
                $student->program_id = $this->mapProgramId($stud);
                $student->study_mode = $this->mapStudyMode($stud);
                $student->program_code = $this->mapProgramCode($stud);
                $student->study_mode_rc = $this->mapStudyModeRc($stud);
                $student->field_id = $this->mapFieldId($stud);
                $student->address = $this->mapAddress($stud);
                $student->city = $this->mapCity($stud);
                $student->phone_no = $this->mapPhone($stud);
                $student->personal_email = $this->mapPersonalEmail($stud);
                $student->religion = $this->mapReligion($stud);
                $student->race = $this->mapRace($stud);
                $student->admission_semester = $this->mapAdmissionSemesterId($stud);
                $student->admission_year = $this->mapAdmissionYear($stud);
                $student->admission_date = $this->mapAdmissionDate($stud);
                $student->current_sem = $this->mapCurrentSemester($stud);
                $student->campus_id = $this->mapCampusId($stud);
                $student->field_code = $this->mapFieldCode($stud);
                $student->cgpa_admission = $this->mapCgpaAdmission($stud);
                $student->spm_result = $this->mapSpmResult($stud);
                $student->english_test = $this->mapEnglishTest($stud);
                $student->study_offer_condition = $this->mapStudyOfferCondition($stud);
                $student->sponsor = $this->mapSponsor($stud);

                if ($isNew) {
                    $student->created_at = time();
                    $student->updated_at = time();
                } else {
                    $student->updated_at = time();
                }

                if (!$student->save(false)) {
                    throw new \RuntimeException('Failed saving Student');
                }

                if ($isNew) {
                    $createdStudents++;
                } else {
                    $updatedStudents++;
                }

                $stud->DONE = 1;
                $stud->save(false);

                $tx->commit();
            } catch (\Throwable $e) {
                $tx->rollBack();
                $errors[] = [
                    'matric' => isset($stud->NO_MATRIK) ? (string)$stud->NO_MATRIK : null,
                    'message' => $e->getMessage(),
                ];
            }
        }

        return [
            'created_users' => $createdUsers,
            'updated_users' => $updatedUsers,
            'created_students' => $createdStudents,
            'updated_students' => $updatedStudents,
            'errors' => $errors,
        ];
    }


    private function parseDate($val)
    {
        if (!$val) {
            return null;
        }
        $ts = strtotime((string)$val);
        return $ts ? date('Y-m-d', $ts) : null;
    }

    private function mapUserId(User $user)
    {
        return $user->id;
    }

    private function mapMatricNo($src)
    {
        return trim((string)$src->NO_MATRIK);
    }

    private function mapNric($src)
    {
        return str_replace('-', '', (string)$src->NO_IC);
    }

    private function mapDateBirth($src)
    {
        return $this->parseDate($src->TARIKH_LAHIR ?? null);
    }

    private function mapMaritalStatus($src)
    {
        $label = trim((string)($src->TARAF_PERKAHWINAN ?? ''));
        if ($label === '') {
            return 0;
        }

        $map = Common::marital2();
        foreach ($map as $id => $name) {
            if (strcasecmp($name, $label) === 0) {
                return (int)$id;
            }
        }

        return 0;
    }

    private function mapGender($src)
    {
        return strcasecmp((string)($src->JANTINA ?? ''), 'LELAKI') === 0 ? 1 : 0;
    }

    private function mapNationality($src)
    {
        $val = trim((string)($src->NEGARA_ASAL ?? ''));
        if ($val === '') {
            return 0;
        }

        $country = Country::find()->where(['country_name' => $val])->one();
        if ($country) {
            return (int)$country->id;
        }

        if (strcasecmp($val, 'Malaysia') === 0) return 158;
        if (strcasecmp($val, 'Pakistan') === 0) return 178;
        if (strcasecmp($val, 'Bangladesh') === 0) return 19;
        if (strcasecmp($val, 'China') === 0) return 48;
        if (strcasecmp($val, 'Ghana') === 0) return 82;
        if (strcasecmp($val, 'Indonesia') === 0) return 101;
        if (strcasecmp($val, 'Jordan') === 0) return 113;
        if (strcasecmp($val, 'Nigeria') === 0) return 164;
        if (strcasecmp($val, 'Thailand') === 0) return 218;

        return 0;
    }

    private function mapCitizenship($src)
    {
        return ((string)($src->KEWARGANEGARAAN ?? '')) === 'Tempatan' ? 1 : 2;
    }

    private function mapProgramId($src)
    {
        $program = trim((string)($src->PROGRAM ?? ''));
        if ($program === 'Sarjana Keusahawanan') {
            return 81;
        }
        if ($program === 'Sarjana Kewangan Islam') {
            return 82;
        }
        if ($program === 'Sarjana') {
            return 84;
        }
        if ($program === 'Doktor Falsafah') {
            return 85;
        }

        return null;
    }

    private function mapStudyMode($src)
    {
        return ((string)($src->TARAF_PENGAJIAN ?? '')) === 'Sepenuh Masa' ? 1 : 2;
    }

    private function mapProgramCode($src)
    {
        return trim((string)$src->KOD_PROGRAM);
    }

    private function mapFieldCode($src)
    {
        return trim((string)$src->KOD_BIDANG);
    }

    private function mapStudyModeRc($src)
    {
        $mod = trim((string)$src->MOD_PENGAJIAN);
        return mb_strtolower($mod) === 'penyelidikan' ? 'research' : 'coursework';
    }

    private function mapFieldId($src)
    {
        $fieldLabel = trim((string)$src->BIDANG_PENGAJIAN);
        if ($fieldLabel === '') {
            return null;
        }
        $field = Field::find()->where(['LOWER([[field_name]])' => mb_strtolower($fieldLabel)])->one();
        return $field ? $field->id : null;
    }

    private function mapAddress($src) { return (string)($src->ALAMAT ?? ''); }
    private function mapCity($src) { return (string)($src->DAERAH ?? ''); }
    private function mapPhone($src) { return (string)($src->NO_TELEFON ?? ''); }
    private function mapPersonalEmail($src) { return (string)($src->EMEL_PERSONAL ?? ''); }

    private function mapReligion($src)
    {
        $label = trim((string)($src->AGAMA ?? ''));
        if ($label === '') {
            return 0;
        }

        $map = Common::religion();
        foreach ($map as $id => $name) {
            if (strcasecmp($name, $label) === 0) return (int)$id;
        }

        $tokens = preg_split('/[\s\/,;|]+/u', mb_strtolower($label, 'UTF-8'), -1, PREG_SPLIT_NO_EMPTY);
        foreach ($map as $id => $name) {
            if (in_array(mb_strtolower($name, 'UTF-8'), $tokens, true)) {
                return (int)$id;
            }
        }

        foreach ($map as $id => $name) {
            if (mb_stripos($label, $name, 0, 'UTF-8') !== false) {
                return (int)$id;
            }
        }

        return 0;
    }

    private function mapRace($src)
    {
        $label = trim((string)($src->BANGSA ?? ''));
        if ($label === '') {
            return 0;
        }

        $map = Common::race();
        foreach ($map as $id => $name) {
            if (strcasecmp($name, $label) === 0) return (int)$id;
        }

        $synonyms = [
            'melayu' => 'Malay',
            'cina' => 'Chinese',
            'china' => 'Chinese',
            'chinese' => 'Chinese',
            'india' => 'Indian',
            'siam' => 'Siam',
            'lain-lain' => 'Others',
            'lain2' => 'Others',
            'others' => 'Others',
        ];

        $lower = mb_strtolower($label, 'UTF-8');
        if (isset($synonyms[$lower])) {
            $target = $synonyms[$lower];
            foreach ($map as $id => $name) {
                if (strcasecmp($name, $target) === 0) return (int)$id;
            }
        }

        $tokens = preg_split('/[\s\/,;|]+/u', mb_strtolower($label, 'UTF-8'), -1, PREG_SPLIT_NO_EMPTY);
        foreach ($map as $id => $name) {
            if (in_array(mb_strtolower($name, 'UTF-8'), $tokens, true)) {
                return (int)$id;
            }
        }

        foreach ($tokens as $tok) {
            if (isset($synonyms[$tok])) {
                $target = $synonyms[$tok];
                foreach ($map as $id => $name) {
                    if (strcasecmp($name, $target) === 0) return (int)$id;
                }
            }
        }

        foreach ($map as $id => $name) {
            if (mb_stripos($label, $name, 0, 'UTF-8') !== false) {
                return (int)$id;
            }
        }

        return 0;
    }

    private function mapAdmissionSemesterId($src)
    {
        $label = trim((string)($src->SESI_MASUK ?? ''));
        return $this->createSemesterId($label);
    }

    private function mapAdmissionYear($src) { return (string)($src->TAHUN_KEMASUKAN ?? ''); }
    private function mapAdmissionDate($src) { return $this->parseDate($src->TARIKH_KEMASUKAN_SEMESTER1 ?? null); }
    private function mapSponsor($src) { return (string)($src->PEMBIAYAAN ?? ''); }
    private function mapCurrentSemester($src) { return (string)($src->SEMESTER ?? ''); }
    private function mapCgpaAdmission($src) { return trim((string)$src->CGPA_KEMASUKAN); }
    private function mapSpmResult($src) { return trim((string)$src->KEPUTUSAN_SPM); }
    private function mapEnglishTest($src) { return trim((string)$src->ENGLISH_TEST); }
    private function mapStudyOfferCondition($src) { return trim((string)$src->JENIS_TAWARAN_PENGAJIAN); }

    private function mapCampusId($src)
    {
        $name = trim((string)($src->KAMPUS ?? ''));
        if ($name === '') {
            return 2;
        }

        switch (mb_strtolower($name, 'UTF-8')) {
            case 'kota':
            case 'kampus kota':
                $campusId = 2;
                break;
            case 'bacok':
            case 'kampus bacok':
            case 'bachok':
                $campusId = 1;
                break;
            case 'kl':
                $campusId = 4;
                break;
            case 'jeli':
                $campusId = 3;
                break;
            default:
                $campusId = null;
                break;
        }

        if ($campusId === null) {
            $campus = Campus::find()->where(['LOWER(campus_short)' => mb_strtolower($name, 'UTF-8')])->one();
            $campusId = $campus ? (int)$campus->id : null;
        }

        return $campusId ? $campusId : 2;
    }


    

    private function ensureStudentSupervisorRole($studentPostgrad, $supervisor, $role)
    {
        $sv = StudentSupervisor::find()->where([
            'student_id' => $studentPostgrad->id,
            'supervisor_id' => $supervisor->id,
            'sv_role' => $role,
        ])->one();

        if ($sv) {
            return;
        }

        $sv = StudentSupervisor::find()->where([
            'student_id' => $studentPostgrad->id,
            'supervisor_id' => $supervisor->id,
        ])
        ->andWhere(['<>', 'sv_role', $role])
        ->one();

        if ($sv) {
            $sv->sv_role = $role;
            $sv->save(false);
            return;
        }

        $sv = new StudentSupervisor();
        $sv->student_id = $studentPostgrad->id;
        $sv->supervisor_id = $supervisor->id;
        $sv->sv_role = $role;
        $sv->save(false);
    }

    private function assignSupervisor($studentPostgrad, $user, $role)
    {
        $supervisor = new Supervisor();
        $supervisor->staff_id = $user->staff_id;
        $supervisor->is_internal = 1;
        if ($supervisor->save(false)) {
            $this->ensureStudentSupervisorRole($studentPostgrad, $supervisor, $role);
        }
    }

    private function createSemesterId($input)
    {
        $semesterNo = 0;
        if (stripos($input, 'september') !== false) {
            $semesterNo = 1;
        } elseif (stripos($input, 'februari') !== false || stripos($input, 'february') !== false) {
            $semesterNo = 2;
        }

        preg_match('/\d{4}\/\d{4}/', $input, $matches);
        if (!isset($matches[0])) {
            return null;
        }

        [$yearFrom, $yearTo] = explode('/', $matches[0]);
        return $yearFrom . $yearTo . $semesterNo;
    }
}
