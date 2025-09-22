<?php
namespace student\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use student\models\LoginForm;
use backend\modules\students\models\Student;
use student\models\forms\ForgotPasswordRequestForm;
use student\models\forms\SetPasswordForm;
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
                        'actions' => ['login', 'error', 'register', 'request-password', 'set-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'logout', 'member', 'error'],
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

    /**
     * Step 1: Ask for matric number and IC number, find student and create/link user, then redirect to set-password
     */
    public function actionRequestPassword()
    {
        $this->layout = "//main-login";
        $model = new ForgotPasswordRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $student = Student::find()
                ->where(['matric_no' => $model->matric_no, 'nric' => $model->nric])
                ->one();
            if (!$student) {
                $model->addError('matric_no', 'No matching student found for the provided Matric No and IC No.');
            } else {
                $user = null;
                if ($student->user_id) {
                    $user = User::findOne($student->user_id);
                }
                if (!$user) {
                    $phone = null;
                    // Fetch email from external API, safely parse response
                    $emailFromApi = null;
                    $url = "https://portal.umk.edu.my/api/v2/esedekah/user?id=" . urlencode($student->matric_no) . "&key=Esedekah2024";
                    $response = @file_get_contents($url);
                    if ($response !== false) {
                        $data = json_decode($response, true);
                        if (is_array($data)) {
                            // Prefer UMK student email if present based on sample payload
                            // { ..., "SM_EMAIL_UMK":"a24b3860ef@siswa.umk.edu.my", ... }
                            if (!empty($data['SM_EMAIL_UMK'])) {
                                $emailFromApi = $data['SM_EMAIL_UMK'];
                            }
                            if (!empty($data['SM_HANDPHONE_NO'])) {
                                $phone = $data['SM_HANDPHONE_NO'];
                            }
                        }
                    }
                    $user = new User();
                    $user->username = $student->matric_no;
                    $user->fullname = $student->st_name ?: $student->matric_no;
                    $user->email = $emailFromApi; // optional
                    $user->status = User::STATUS_ACTIVE;
                    $user->generateAuthKey();
                    // set a temporary random password, student will replace it in next step
                    $user->setPassword(Yii::$app->security->generateRandomString(12));
                    if (!$user->save(false)) {
                        Yii::$app->session->addFlash('error', 'Failed to create user account.');
                        return $this->refresh();
                    }
                    $student->user_id = $user->id;
                    $student->phone = $phone;
                    $student->save(false);
                }
                // generate a one-time token and redirect to set-password page
                $user->generatePasswordResetToken();
                $user->save(false);
                return $this->redirect(['set-password', 'token' => $user->password_reset_token]);
            }
        }
        return $this->render('request-password', [
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
	


	

	
}
