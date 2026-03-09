<?php
namespace student\controllers;

use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;
use yii\base\InvalidParamException;
use student\models\LoginForm;
use backend\modules\students\models\Student;
use backend\modules\postgrad\models\Student as PostgradStudent;
use backend\modules\postgrad\models\StudentRegister as PostgradStudentRegister;
use backend\modules\postgrad\models\StudentStage as PostgradStudentStage;
use student\models\forms\ForgotPasswordRequestForm;
use student\models\forms\SetPasswordForm;
use student\models\ResetPasswordForm;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'register', 'request-password', 'set-password', 'reset-password', 'login-as'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'logout', 'member', 'error', 'semester-registration', 'research-progress', 'research-progress-view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
    
    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            // change layout for error action
            if ($action->id=='error') $this->layout ='error';
            return true;
        } else {
            return false;
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
       if (Yii::$app->user->isGuest) {
           return $this->redirect(['site/login']);
       }
       return $this->render('index');
        
    }
	
	
	
    public function actionSemesterRegistration()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $user = Yii::$app->user->identity;
        if (!$user || !$user->studentPostGrad) {
            Yii::$app->session->addFlash('error', 'Semester registration page is available for postgraduate students only.');
            return $this->redirect(['index']);
        }

        $student = PostgradStudent::findOne($user->studentPostGrad->id);
        if (!$student) {
            Yii::$app->session->addFlash('error', 'Postgraduate student record not found.');
            return $this->redirect(['index']);
        }

        $registrations = PostgradStudentRegister::find()
            ->where(['student_id' => (int)$student->id])
            ->orderBy(['semester_id' => SORT_ASC])
            ->all();

        $latestRegistration = !empty($registrations) ? $registrations[0] : null;
        foreach ($registrations as $registration) {
            if ($registration->date_register) {
                $latestRegistration = $registration;
                break;
            }
        }

        return $this->render('semester-registration', [
            'student' => $student,
            'registrations' => $registrations,
            'latestRegistration' => $latestRegistration,
        ]);
    }
	
    public function actionResearchProgress()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $user = Yii::$app->user->identity;
        if (!$user || !$user->studentPostGrad) {
            Yii::$app->session->addFlash('error', 'Research progress page is available for postgraduate students only.');
            return $this->redirect(['index']);
        }

        $student = PostgradStudent::findOne($user->studentPostGrad->id);
        if (!$student) {
            Yii::$app->session->addFlash('error', 'Postgraduate student record not found.');
            return $this->redirect(['index']);
        }

        $stages = PostgradStudentStage::find()
            ->where(['student_id' => (int)$student->id])
            ->orderBy(['semester_id' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        return $this->render('research-progress', [
            'student' => $student,
            'stages' => $stages,
        ]);
    }
	
    public function actionResearchProgressView($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $user = Yii::$app->user->identity;
        if (!$user || !$user->studentPostGrad) {
            Yii::$app->session->addFlash('error', 'Research progress page is available for postgraduate students only.');
            return $this->redirect(['index']);
        }

        $student = PostgradStudent::findOne($user->studentPostGrad->id);
        if (!$student) {
            Yii::$app->session->addFlash('error', 'Postgraduate student record not found.');
            return $this->redirect(['index']);
        }

        $stage = PostgradStudentStage::find()
            ->where(['id' => (int)$id, 'student_id' => (int)$student->id])
            ->one();

        if (!$stage) {
            Yii::$app->session->addFlash('error', 'Research stage record not found.');
            return $this->redirect(['research-progress']);
        }

        return $this->render('research-progress-view', [
            'student' => $student,
            'stage' => $stage,
        ]);
    }
	
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->goHome();
        } else {
            $this->layout = "//main-login";
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLoginAs($token)
    {
        $user = User::findByPasswordResetToken($token);
        if (!$user) {
            Yii::$app->session->addFlash('error', 'Invalid or expired login token.');
            return $this->redirect(['login']);
        }

        Yii::$app->user->logout();

        if (Yii::$app->user->login($user, 0)) {
            Yii::$app->session->set('studentLevel', $user->studentPostGrad ? 'PG' : 'UG');
            $user->removePasswordResetToken();
            $user->save(false);
            return $this->goHome();
        }

        Yii::$app->session->addFlash('error', 'Unable to login as selected student.');
        return $this->redirect(['login']);
    }

    /**
     * Step 1: Ask for matric number and IC number, find student and create/link user, then redirect to set-password
     */
    public function actionRequestPassword()
    {
        $this->layout = "//main-login";
        $model = new ForgotPasswordRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $matricNo = $model->matric_no;
            $isPostgrad = $this->isPostgradMatricNumber($matricNo);
            $student = $isPostgrad
                ? PostgradStudent::find()->where(['matric_no' => $matricNo])->one()
                : Student::find()->where(['matric_no' => $matricNo])->one();

            $apiData = null;
            if (!$student) {
                $apiData = $this->fetchStudentApiData($matricNo);
                if (!$apiData) {
                    $model->addError('matric_no', 'Student record was not found.');
                    return $this->render('request-password', [
                        'model' => $model,
                    ]);
                }
                $student = $this->createStudentFromApi($matricNo, $isPostgrad, $apiData);
                if (!$student) {
                    Yii::$app->session->addFlash('error', 'Unable to create student record. Please contact the administrator.');
                    return $this->refresh();
                }
            } else {
                $linkedUser = !empty($student->user_id) ? User::findOne($student->user_id) : null;
                if (!$linkedUser || empty($linkedUser->email)) {
                    $apiData = $this->fetchStudentApiData($matricNo);
                }
            }

            $user = $this->ensureStudentUser($student, $isPostgrad, $apiData);
            if (!$user) {
                Yii::$app->session->addFlash('error', 'Unable to prepare user account for password reset.');
                return $this->refresh();
            }

            if (empty($user->email)) {
                $model->addError('matric_no', 'No email address was found for this matric number.');
            } elseif ($this->sendPasswordResetEmail($user)) {
                Yii::$app->session->addFlash('success', 'A password reset link has been sent to your registered email address.');
                return $this->redirect(['login']);
            } else {
                Yii::$app->session->addFlash('error', 'Unable to send password reset email. Please try again later.');
            }
        }
        return $this->render('request-password', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        $this->layout = "//main-login";
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->redirect(['login']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Step 2: Let student set their password using the reset token
     */
    public function actionSetPassword($token)
    {
        $this->layout = "//main-login";
        $user = User::findByPasswordResetToken($token);
        if (!$user) {
            Yii::$app->session->addFlash('error', 'Invalid or expired token.');
            return $this->redirect(['request-password']);
        }
        $model = new SetPasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->setPassword($model->password);
            $user->removePasswordResetToken();
            if ($user->save(false)) {
                Yii::$app->session->addFlash('success', 'Password set successfully. You can now sign in.');
                return $this->redirect(['login']);
            } else {
                Yii::$app->session->addFlash('error', 'Failed to set password.');
            }
        }
        return $this->render('set-password', [
            'model' => $model,
        ]);
    }
	

    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        return $this->redirect(['/site/login']);
    }

    protected function isPostgradMatricNumber($matricNo)
    {
        return preg_match('/^[A-Z]\d{2}[DE]/i', (string)$matricNo) === 1;
    }

    protected function fetchStudentApiData($matricNo)
    {
        $url = 'https://portal.umk.edu.my/api/v2/esedekah/user?id=' . urlencode($matricNo) . '&key=Esedekah2024';
        $response = @file_get_contents($url);
        if ($response === false) {
            return null;
        }

        $data = json_decode($response, true);
        if (!is_array($data)) {
            return null;
        }

        if (empty($data['SM_STUDENT_ID']) || strcasecmp((string)$data['SM_STUDENT_ID'], (string)$matricNo) !== 0) {
            return null;
        }

        return $data;
    }

    protected function createStudentFromApi($matricNo, $isPostgrad, array $apiData)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($isPostgrad) {
                $student = new PostgradStudent();
                $student->matric_no = $matricNo;
                $student->nric = isset($apiData['SM_IC_NO']) ? (string)$apiData['SM_IC_NO'] : null;
                $student->phone_no = isset($apiData['SM_HANDPHONE_NO']) ? (string)$apiData['SM_HANDPHONE_NO'] : null;
                $student->personal_email = isset($apiData['SM_EMAIL_UMK']) ? (string)$apiData['SM_EMAIL_UMK'] : null;
                $student->status = PostgradStudent::STATUS_ACTIVE;
            } else {
                $student = new Student();
                $student->matric_no = $matricNo;
                $student->nric = isset($apiData['SM_IC_NO']) ? (string)$apiData['SM_IC_NO'] : null;
                $student->st_name = !empty($apiData['SM_STUDENT_NAME']) ? (string)$apiData['SM_STUDENT_NAME'] : $matricNo;
            }

            if (!$student->save(false)) {
                $transaction->rollBack();
                return null;
            }

            $transaction->commit();
            return $student;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(), __METHOD__);
            return null;
        }
    }

    protected function ensureStudentUser($student, $isPostgrad, array $apiData = null)
    {
        if (!empty($student->user_id)) {
            $existingUser = User::findOne($student->user_id);
            if ($existingUser) {
                if (empty($existingUser->email) && !empty($apiData['SM_EMAIL_UMK'])) {
                    $email = (string)$apiData['SM_EMAIL_UMK'];
                    $emailOwner = User::findByEmail($email);
                    if (!$emailOwner || (int)$emailOwner->id === (int)$existingUser->id) {
                        $existingUser->email = $email;
                        $existingUser->save(false);
                    }
                }
                return $existingUser;
            }
        }

        $user = User::findByUsername($student->matric_no);
        if ($user && empty($user->email) && !empty($apiData['SM_EMAIL_UMK'])) {
            $email = (string)$apiData['SM_EMAIL_UMK'];
            $emailOwner = User::findByEmail($email);
            if (!$emailOwner || (int)$emailOwner->id === (int)$user->id) {
                $user->email = $email;
                $user->save(false);
            }
        }
        if (!$user) {
            $user = new User();
            $user->username = $student->matric_no;
            $user->fullname = $isPostgrad
                ? (!empty($apiData['SM_STUDENT_NAME']) ? (string)$apiData['SM_STUDENT_NAME'] : $student->matric_no)
                : (!empty($student->st_name) ? $student->st_name : $student->matric_no);
            $email = !empty($apiData['SM_EMAIL_UMK']) ? (string)$apiData['SM_EMAIL_UMK'] : null;
            $emailOwner = $email ? User::findByEmail($email) : null;
            $user->email = (!$emailOwner || ($emailOwner && (int)$emailOwner->id === (int)$user->id)) ? $email : null;
            $user->status = User::STATUS_ACTIVE;
            $user->generateAuthKey();
            $user->setPassword(Yii::$app->security->generateRandomString(12));
            if (!$user->save(false)) {
                return null;
            }
        }

        $student->user_id = $user->id;
        if ($isPostgrad && empty($student->personal_email) && !empty($apiData['SM_EMAIL_UMK'])) {
            $student->personal_email = (string)$apiData['SM_EMAIL_UMK'];
        }
        if ($isPostgrad && empty($student->phone_no) && !empty($apiData['SM_HANDPHONE_NO'])) {
            $student->phone_no = (string)$apiData['SM_HANDPHONE_NO'];
        }
        if (!$isPostgrad && empty($student->st_name) && !empty($apiData['SM_STUDENT_NAME'])) {
            $student->st_name = (string)$apiData['SM_STUDENT_NAME'];
        }
        if (!$student->save(false)) {
            return null;
        }

        return $user;
    }

    protected function sendPasswordResetEmail(User $user)
    {
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save(false)) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'FKP PORTAL'])
            ->setTo($user->email)
            ->setSubject('Complete password reset on FKP PORTAL')
            ->send();
    }
	


	

	
}
