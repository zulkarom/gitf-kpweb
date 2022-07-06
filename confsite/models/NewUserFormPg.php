<?php
namespace confsite\models;

use yii\base\Model;
use Yii;
use common\models\User;
use backend\modules\conference\models\Associate;
use backend\modules\conference\models\ConfRegistration;
use yii\db\Expression;

/**
 * Signup form
 */
class NewUserFormPg extends Model
{
    public $fullname;
    public $email;
    public $institution;
    public $country_id;
    public $password;
    public $password_repeat;

	public $matric_no;
	public $cumm_sem;
	public $pro_study;
	public $phone;
	
	public $sv_main;
	public $sv_co1;
	public $sv_co2;
	public $sv_co3;
	

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //Register
            
            [['email', 'password', 'password_repeat', 'fullname', 'sv_main', 'pro_study', 'cumm_sem', 'matric_no', 'phone'], 'required'],
            
            [['email'], 'email'],
            ['email', 'trim'],
            ['email', 'string', 'max' => 100],
            
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email has already been taken. If you are sure this is your email, probably you have already registered to the system. Try resetting your password if you do not recall it'],
            
            ['password', 'string', 'min' => 6],
            
            [['fullname', 'institution', 'sv_main', 'sv_co1', 'sv_co2', 'sv_co3'], 'string', 'min' => 2, 'max' => 100],
            
            
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
            
        ];

    }
	
	public function attributeLabels()
    {
        $label = parent::attributeLabels();

        $label['email'] = 'Email';
        $label['password'] = 'Password';
        $label['password_repeat'] = 'Repeat Password';

        $label['fullname'] = 'Name';
        $label['institution'] = 'Institution';
        $label['cumm_sem'] = 'Cumulative Semester';
        $label['pro_study'] = 'Program of Study';

        $label['sv_main'] = 'Main Supervisor';
        $label['sv_co1'] = 'Co-Supervisor I';
        $label['sv_co2'] = 'Co-Supervisor II';
        $label['sv_co3'] = 'Co-Supervisor III';
        
        return $label;
    } 
    
    
    public function signup($conf)
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
        $user->fullname = $this->fullname;
        $user->username = $this->email;
        $user->email = $this->email;
        
        $user->status = 9;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        if($user->save()){
            //check maklumat associate
            $associate = $user->associate;
			
			if(!$associate){
			    $new = new Associate();
			    $new->scenario = 'raw';
                $new->user_id = $user->id;
                $new->institution = $this->institution;
                $new->matric_no = $this->matric_no;
                $new->cumm_sem = $this->cumm_sem;
                $new->pro_study = $this->pro_study;
                $new->phone = $this->phone;
                $new->sv_main = $this->sv_main;
                $new->sv_co1 = $this->sv_co1;
                $new->sv_co2 = $this->sv_co2;
                $new->sv_co3 = $this->sv_co3;
			    
			    if(!$new->save()){
					$new->flashError();
				}
			}
            //register conference terus

            $reg = new ConfRegistration;
            $reg->user_id = $user->id;
            $reg->conf_id = $conf->id;
            $reg->reg_at = new Expression('NOW()');
            $reg->confly_number = $reg->nextConflyNumber();
            $flag = $reg->save();


            if($this->sendEmailApi($user, $conf)){
                $flag = true;
            }else{
                $flag = false;
                Yii::$app->session->addFlash('danger', "Cannot send email verification");
            }
        }else{
            $user->flashError();
        };

            if($flag){
                $transaction->commit();
                return true;
            }
            
            
        }
        catch (\Exception $e) 
        {
            $transaction->rollBack();
            echo $e->getMessage();die();
            Yii::$app->session->addFlash('error', $e->getMessage());
        }
        
        
        return false;
    }
    
    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmailApi($user, $conf)
    {
        $email = urlencode($user->email);
        $from = urlencode($conf->conf_abbr);
        $confurl = urlencode($conf->conf_url);
        $code = $user->verification_token;
        $secret = "dj38rqp";
        $key = md5($code.$secret);
        $url = "https://api-mailer.skyhint.com/fkpconf/verify/" . $email . "/" . $from .  "/" . $confurl . "/" . $code . "/" . $key;
        try {
			if(file_get_contents($url) == 'true'){
                return true;
            }else{
                return false;
            }
		}
		catch (\Exception $e) {
			return false;
		}
        /* return Yii::$app
        ->mailer
        ->compose(
            ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
            ['user' => $user, 'conf_id' => $conf_id]
            )
        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['senderName']])
        ->setTo($this->email)
        ->setSubject('Account registration at ' . Yii::$app->name)
        ->send(); */
    }

    protected function sendEmail($user, $conf)
    {
        return Yii::$app
        ->mailer
        ->compose(
            ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
            ['user' => $user, 'conf_id' => $conf->id]
            )
        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['senderName']])
        ->setTo($this->email)
        ->setSubject('Account registration at ' . Yii::$app->name)
        ->send(); 
    }
    public function listProgramStudy(){
		return Associate::listProgramStudy();
	}

    public function listSemNumber(){
		return Associate::listSemNumber();
	}

    public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }
    }
}
