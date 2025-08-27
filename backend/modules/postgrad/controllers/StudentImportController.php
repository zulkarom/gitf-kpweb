<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\Student;
use student\models\StudentData as SrcStudentData;
use backend\modules\postgrad\models\StudentPostGradSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\User;
use backend\modules\esiap\models\Program;
use backend\models\Campus;
use backend\models\Semester;
use backend\modules\postgrad\models\Field;
use common\models\Country;
use common\models\Common;
use backend\modules\postgrad\models\StudentData2;
use backend\modules\postgrad\models\StudentData4;
use backend\modules\postgrad\models\StudentSupervisor;
use backend\modules\postgrad\models\Supervisor;

/**
 * StudentImportController provides import utilities for Postgrad students.
 */
class StudentImportController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    public function actionQuerySupervisorBersama(){
        $srcRows = SrcStudentData::find()->where(['DONE' => 0])->limit(50)->all();
        foreach ($srcRows as $stud) {
            //start with penyelia utama
            $student_postgrad = Student::find()->where(['matric_no' => $stud->NO_MATRIK])->one();
            $err = '';
            $supervisor = $stud->PENYELIA_BERSAMA;
            $err .= 'Before: ' . $supervisor . " - ";
            $strip = $this->normalizeName($supervisor);
            $err .= 'Strip: ' . $strip . " - ";
            //find in user - staff
            if($strip){
                $user = User::find()->alias('a')
                ->select('s.id as staff_id, a.id')
                ->joinWith(['staff s'])
                ->where(['like', 'fullname', $strip])
                ->one();
                if($user){
                    //echo 'Found: ' . $user->fullname . " Asal: ".$supervisor."<br />";
                    //find in pg_supervisor
                    $supervisor = Supervisor::find()->where(['staff_id' => $user->staff_id])->one();
                    try{
                        $transaction = Yii::$app->db->beginTransaction();
                        if($supervisor){
                            //echo 'Found: ' . $supervisor->sv_name . " Asal: ".$supervisor."<br />";

                            $sv = StudentSupervisor::find()->where(['student_id' => $student_postgrad->id, 'supervisor_id' => $supervisor->id, 'sv_role' => 2])->one();
                            if(!$sv){
                                //tgk ada  tak role 1
                                $sv = StudentSupervisor::find()->where(['student_id' => $student_postgrad->id, 'supervisor_id' => $supervisor->id, 'sv_role' => 1])->one();
                                if($sv){
                                    $sv->sv_role = 2;
                                    $sv->save(false);
                                }else{
                                    $sv = new StudentSupervisor();
                                    $sv->student_id = $student_postgrad->id;
                                    $sv->supervisor_id = $supervisor->id;
                                    $sv->sv_role = 2;
                                    $sv->save(false);
                                }
                            }
                               $stud->DONE= 1;
                               $stud->save(false);
                               echo 'done assign: ' . $student_postgrad->matric_no . " to ". $user->fullname ."<br />";
                        }else{
                           // echo '<span style="color:red">Not Found: ' . $strip . $err ."</span><br />";
                           $supervisor = new Supervisor();
                           $supervisor->staff_id = $user->staff_id;
                           $supervisor->is_internal = 1;
                           if($supervisor->save(false)){
                               //add to student supervisor
                               $sv = StudentSupervisor::find()->where(['student_id' => $student_postgrad->id, 'supervisor_id' => $supervisor->id, 'sv_role' => 2])->one();
                               if(!$sv){
                                //tgk ada  tak role 1
                                $sv = StudentSupervisor::find()->where(['student_id' => $student_postgrad->id, 'supervisor_id' => $supervisor->id, 'sv_role' => 1])->one();
                                if($sv){
                                    $sv->sv_role = 2;
                                    $sv->save(false);
                                }else{
                                   $sv = new StudentSupervisor();
                                   $sv->student_id = $student_postgrad->id;
                                   $sv->supervisor_id = $supervisor->id;
                                   $sv->sv_role = 2;
                                   $sv->save(false);
                               }
                               $stud->DONE= 1;
                               $stud->save(false);
                               echo 'done assign: ' . $student_postgrad->matric_no . " to ". $user->fullname ."<br />";
                                }
                            }
                        }
                        $transaction->commit();
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                    }
                }else{
                    echo '<span style="color:red">Not Found: ' . $strip . $err ."</span><br />";
                }
            }else{
                echo 'Empty: ' . $strip . $err ."<br />";
            }
            
            
        }
        exit;
    }

    /**
     * Import from pg_student_data3 (StudentData) into pg_student (Student).
     * - Creates/updates User by username = NO_MATRIK
     * - Creates/updates Student by matric_no (or user_id if present)
     * - Per-record transaction; collects summary
     */
    public function actionImport()
    {
        die('test');
        $createdUsers = 0; $updatedUsers = 0; $createdStudents = 0; $updatedStudents = 0; $errors = [];
        $srcRows = SrcStudentData::find()->where(['DONE' => 0])->limit(50)->all();
        foreach ($srcRows as $stud) {
                $tx = Yii::$app->db->beginTransaction();
                try {
                    // 1) Ensure User
                    $username = trim((string)$stud->NO_MATRIK);
                    if ($username === '') { throw new \RuntimeException('Missing NO_MATRIK'); }
                    $user = User::find()
                    ->where(['email' => $stud->EMEL_PELAJAR])
                    ->orWhere(['username' => $username])
                    ->one();
                    if (!$user) {
                        $user = new User();
                        $user->username = $username;
                        $random = (string)random_int(100000, 999999);
                        $user->password_hash = Yii::$app->security->generatePasswordHash($random);
                        $user->email = $stud->EMEL_PELAJAR ?: ($username.'@example.local');
                        $user->fullname = $stud->NAMA_PELAJAR ?: $username;
                        $user->status = 10;
                        if (!$user->save(false)) { throw new \RuntimeException('Failed saving new User'); }
                        $createdUsers++;
                    } else {
                        $user->email = $stud->EMEL_PELAJAR ?: $user->email;
                        $user->username = $username;
                        $user->fullname = $stud->NAMA_PELAJAR ?: $user->fullname;
                        $user->status = 10;
                        $user->save(false);
                        $updatedUsers++;
                    }

                    // 2) Upsert Student
                    $student = Student::find()->where(['matric_no' => $username])->one();
                    if (!$student) { $student = new Student(); }
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
                    $student->status = $this->mapStudentStatus($stud);
                    $student->field_code = $this->mapFieldCode($stud);
                    $student->cgpa_admission = $this->mapCgpaAdmission($stud);
                    $student->spm_result = $this->mapSpmResult($stud);
                    $student->english_test = $this->mapEnglishTest($stud);
                    $student->study_offer_condition = $this->mapStudyOfferCondition($stud);
                    $student->sponsor = $this->mapSponsor($stud);
                    //

                    
                    
                    

                    // $student->bachelor_name = $this->mapBachelorName($stud);
                    // $student->bachelor_university = $this->mapBachelorUniversity($stud);
                    // $student->bachelor_cgpa = $this->mapBachelorCgpa($stud);
                    // $student->bachelor_year = $this->mapBachelorYear($stud);

                    
                    
                    
                    if($isNew){
                        $student->created_at = time();
                        $student->updated_at = time();
                    }else{
                        $student->updated_at = time();
                    }
                    


                    if (!$student->save(false)) { throw new \RuntimeException('Failed saving Student'); }
                    if ($isNew) { $createdStudents++; } else { $updatedStudents++; }
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

        $summary = [
            'created_users' => $createdUsers,
            'updated_users' => $updatedUsers,
            'created_students' => $createdStudents,
            'updated_students' => $updatedStudents,
            'errors' => $errors,
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $summary;
    }

    private function parseDate($val)
    {
        if (!$val) { return null; }
        $ts = strtotime((string)$val);
        return $ts ? date('Y-m-d', $ts) : null;
    }

    // Mapping helpers (one per target column/field)
    private function mapUserId(User $user) { return $user->id; }
    private function mapMatricNo($src) { return trim((string)$src->NO_MATRIK); }
    private function mapNric($src) { return str_replace('-', '', (string)$src->NO_IC); }
    private function mapDateBirth($src) { return $this->parseDate($src->TARIKH_LAHIR ?? null); }
    private function mapMaritalStatus($src)
    {
        $label = trim((string)($src->TARAF_PERKAHWINAN ?? ''));
        if ($label === '') { return 0; }

        $map = Common::marital2(); // [id => label]
        foreach ($map as $id => $name) {
            if (strcasecmp($name, $label) === 0) { return (int)$id; }
        }

        return 0; // Unknown or not in dictionary
    }
    private function mapGender($src) { return strcasecmp((string)($src->JANTINA ?? ''), 'LELAKI') === 0 ? 1 : 0; }
    
    private function mapNationality($src)
    {
        $val = trim((string)($src->NEGARA_ASAL ?? ''));
        if ($val === '') { return 0; }
        // Try DB lookup by country name
        $country = Country::find()->where(['country_name' => $val])->one();

        if ($country) { return (int)$country->id; }
        // Fallback quick map for common cases
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
    private function mapCitizenship($src) { return ((string)($src->KEWARGANEGARAAN ?? '')) === 'Tempatan' ? 1 : 2; }

    //program_id
    private function mapProgramId($src)
    {
        $program = trim((string)($src->PROGRAM ?? ''));
        if ($program === 'Sarjana Keusahawanan') { return 81; }
        if ($program === 'Sarjana Kewangan Islam') { return 82; }
        if ($program === 'Sarjana') { return 84; }
        if ($program === 'Doktor Falsafah') { return 85; }
        
    }

    private function mapStudyMode($src) { return ((string)($src->TARAF_PENGAJIAN ?? '')) === 'Sepenuh Masa' ? 1 : 2; }


    private function mapAddress($src) { return (string)($src->ALAMAT ?? ''); }
    private function mapCity($src) { return (string)($src->DAERAH ?? ''); }
    private function mapPhone($src) { return (string)($src->NO_TELEFON ?? ''); }
    private function mapPersonalEmail($src) { return (string)($src->EMEL_PERSONAL ?? ''); }

    private function mapReligion($src)
{
    $label = trim((string)($src->AGAMA ?? ''));
    if ($label === '') { return 0; }

    $map = Common::religion(); // [id => label]

    // 1) Exact case-insensitive match
    foreach ($map as $id => $name) {
        if (strcasecmp($name, $label) === 0) return (int)$id;
    }

    // 2) Token-based match (handles "Islam/ Melayu", "Islam, Melayu", etc.)
    $tokens = preg_split('/[\s\/,;|]+/u', mb_strtolower($label, 'UTF-8'), -1, PREG_SPLIT_NO_EMPTY);
    foreach ($map as $id => $name) {
        if (in_array(mb_strtolower($name, 'UTF-8'), $tokens, true)) {
            return (int)$id;
        }
    }

    // 3) Fallback: contains check (e.g., “islamic faith”)
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
    if ($label === '') { return 0; }

    $map = Common::race(); // [id => label]

    // 1) Exact case-insensitive match
    foreach ($map as $id => $name) {
        if (strcasecmp($name, $label) === 0) return (int)$id;
    }

    // Optional: handle common Malay synonyms (helps “Melayu”, “Cina”, “India”, “Lain-lain”)
    $synonyms = [
        'melayu'   => 'Malay',
        'cina'     => 'Chinese',
        'china'     => 'Chinese',
        'chinese'     => 'Chinese',
        'india'    => 'Indian',
        'siam'     => 'Siam',
        'lain-lain'=> 'Others',
        'lain2'    => 'Others',
        'others'   => 'Others',
    ];

    $lower = mb_strtolower($label, 'UTF-8');
    if (isset($synonyms[$lower])) {
        $target = $synonyms[$lower];
        foreach ($map as $id => $name) {
            if (strcasecmp($name, $target) === 0) return (int)$id;
        }
    }

    // 2) Token-based match (handles "Melayu/ Islam", "Cina; Buddha", etc.)
    $tokens = preg_split('/[\s\/,;|]+/u', mb_strtolower($label, 'UTF-8'), -1, PREG_SPLIT_NO_EMPTY);

    // Match dictionary labels
    foreach ($map as $id => $name) {
        if (in_array(mb_strtolower($name, 'UTF-8'), $tokens, true)) {
            return (int)$id;
        }
    }

    // Match synonyms as tokens
    foreach ($tokens as $tok) {
        if (isset($synonyms[$tok])) {
            $target = $synonyms[$tok];
            foreach ($map as $id => $name) {
                if (strcasecmp($name, $target) === 0) return (int)$id;
            }
        }
    }

    // 3) Fallback: contains check
    foreach ($map as $id => $name) {
        if (mb_stripos($label, $name, 0, 'UTF-8') !== false) {
            return (int)$id;
        }
    }

    return 0; // Unknown
}

    private function mapBachelorName($src) { return (string)($src->NAMA_SARJANA_MUDA ?? ''); }
    private function mapBachelorUniversity($src) { return (string)($src->UNIVERSITI_SARJANA_MUDA ?? ''); }
    private function mapBachelorCgpa($src) { return (string)($src->CGPA_SARJANA_MUDA ?? ''); }
    private function mapBachelorYear($src)
    {
        $y = $src->TAHUN_SARJANA_MUDA ?? null;
        return is_numeric($y) && (int)$y > 0 ? (int)$y : null;
    }
    private function mapAdmissionSemesterId($src)
    {
        $label = trim((string)($src->SESI_MASUK ?? ''));
        $code = $this->createSemesterId($label);
        return $code;
    }
    private function mapAdmissionYear($src) { return (string)($src->TAHUN_KEMASUKAN ?? ''); }
    private function mapAdmissionDate($src) { return $this->parseDate($src->TARIKH_KEMASUKAN_SEMESTER1 ?? null); }
    private function mapSponsor($src) { return (string)($src->PEMBIAYAAN ?? ''); }
    private function mapCurrentSemester($src) { return (string)($src->SEMESTER ?? ''); }

    private function mapCampusId($src)
    {
        $name = trim((string)($src->KAMPUS ?? ''));
        if ($name === '') { return 2; }

        
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
        
        return $campusId ? $campusId : 2; // default to 2 if not found
    }

private function mapStudentStatus($src)
{
    // Try common source fields; adjust if your column name differs
    $label = trim((string)($src->STATUS));


    // Case-insensitive checks
    if (preg_match('/\baktif\b/i', $label)) {
        return Student::STATUS_ACTIVE;      // 10
    }
    if (preg_match('/\bterminat(e|ed|ion)?\b/i', $label)) {
        return Student::STATUS_TERMINATED;  // 40
    }

    // Optional: extend mappings
    if (preg_match('/\btangguh\b/i', $label)) {
        return Student::STATUS_DEFERRED;    // 20
    }
    if (preg_match('/\btarik\s*diri\b/i', $label)) {
        return Student::STATUS_WITHDRAWN;   // 30
    }
    if (preg_match('/\bgradu(asi|ate|ated|ation)\b/i', $label)) {
        return Student::STATUS_GRADUATED;   // 100
    }

    // Fallback
    return Student::STATUS_NOT_ACTIVE;      // 0
}

private function mapProgramCode($src){
    return trim((string)$src->KOD_PROGRAM);
}
private function mapFieldCode($src){
    return trim((string)$src->KOD_BIDANG);
}

private function mapStudyModeRc($src){
    $mod = trim((string)$src->MOD_PENGAJIAN);
    return mb_strtolower($mod) === 'penyelidikan' ? 'research' : 'coursework';
}


private function mapFieldId($src) {
    $fieldLabel = trim((string)$src->BIDANG_PENGAJIAN);
    if ($fieldLabel === '') { return null; }
    $field = Field::find()->where(['LOWER([[field_name]])' => mb_strtolower($fieldLabel)])->one();
    return $field ? $field->id : null;
}

function createSemesterId($input) {
    // Contoh input:
    // "Semester September, Sesi Akademik 2022/2023"
    // "Semester Februari, Sesi Akademik 2023/2024"

    // Cari semester (September/Februari)
    $semesterNo = 0;
    if (stripos($input, "september") !== false) {
        $semesterNo = 1;
    } elseif (stripos($input, "februari") !== false || stripos($input, "february") !== false) {
        $semesterNo = 2;
    }

    // Extract tahun akademik (format xxxx/yyyy)
    preg_match('/\d{4}\/\d{4}/', $input, $matches);
    if (!isset($matches[0])) {
        return null; // kalau format tak jumpa
    }

    list($yearFrom, $yearTo) = explode('/', $matches[0]);

    // Bentuk ID: yearFrom + yearTo + semesterNo
    return $yearFrom . $yearTo . $semesterNo;
}

private function mapCgpaAdmission($src){
    return trim((string)$src->CGPA_KEMASUKAN);
}
private function mapSpmResult($src){
    return trim((string)$src->KEPUTUSAN_SPM);
}
private function mapEnglishTest($src){
    return trim((string)$src->ENGLISH_TEST);
}
private function mapStudyOfferCondition($src){
    return trim((string)$src->JENIS_TAWARAN_PENGAJIAN);
}





function normalizeName($nama_input) {
    // Senarai gelaran yang nak dibuang
    $titles = [
       "Professor", "Proffesor", "Prof.", "Prof", "Porf", "Madya", "Ts.", "Ts", "Dr.", "Dr", "Encik",
        "En.", "En",
        "Dato'", "Assoc.", "Associate", 
    ];

    // Buang gelaran (case insensitive)
    $nama = str_ireplace($titles, "", $nama_input);

    // Senarai pemisah (bin/binti/dll.)
    $splitters = array_map('strtolower', [" Bin ", " Binti ", " Bt. ", " Bt ", " bte ", " a/l ", " a/p "]);

    // Tukar semua pemisah kepada simbol sama
    $nama = str_ireplace($splitters, "|", strtolower($nama));

    // Pecahkan ikut simbol → ambil bahagian sebelum "Bin/Binti/a/l/a/p"
    $parts = explode("|", $nama);
    $firstPart = trim($parts[0]);

    // Kemaskan spacing
    $firstPart = preg_replace('/\s+/', ' ', $firstPart);

    // Pecahkan kepada perkataan
    $words = explode(" ", $firstPart);

    // Hadkan kepada 3 perkataan maksimum
    $limited = array_slice($words, 0, 2);

    // Cantumkan balik
    return implode(" ", $limited);
}


}