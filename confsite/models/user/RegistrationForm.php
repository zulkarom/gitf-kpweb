<?php
namespace confsite\models\user;

//use dektrium\user\models\User;
use Yii;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use backend\modules\conference\models\Associate;
use yii\helpers\ArrayHelper;

/**
 * Signup form
 */
class RegistrationForm extends BaseRegistrationForm
{
	public $title;
	public $fullname;
	public $institution;
	public $assoc_address;
	public $country_id;
	public $matric_no;
	public $cumm_sem;
	public $pro_study;
	public $phone;
	
	public $sv_main;
	public $sv_co1;
	public $sv_co2;
	public $sv_co3;
	
	public $password_repeat;
	
	public function rules()
    {
        $rules = parent::rules();
		
		$rules['password_repeatRequired'] = ['password_repeat', 'required'];
		
		$rules['fullnameRequired'] = ['fullname', 'required'];
		
		$rules[] = [['sv_main', 'pro_study', 'cumm_sem', 'matric_no', 'phone', 'country_id'], 'required'];
		
		$rules[] = [['institution', 'sv_main', 'sv_co1', 'sv_co2', 'sv_co3'], 'string'];
		
		$rules['assoc_addressString'] = ['assoc_address', 'string'];
		
		$rules['titleString'] = ['title', 'string'];

		
		$rules['password_repeatCompare'] = ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ];
		

		//
        return $rules;
    }
	
	public function attributeLabels()
    {
		$label = parent::attributeLabels();
		$assoc = new Associate;
		$label2 = $assoc->attributeLabels();
        return ArrayHelper::merge($label, $label2);
    }
	
	public function listSemNumber(){
		return Associate::listSemNumber();
	}
	
	public function listProgramStudy(){
		return Associate::listProgramStudy();
	}
	
	public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);


        if ($user->register()) {
            
            
            

			$assoc = new Associate;
			$assoc->user_id = $user->id;
			//$assoc->title = $this->title;
			//$assoc->assoc_address = $this->assoc_address;
			$assoc->country_id = $this->country_id;
			//$assoc->institution = $this->institution;
			$assoc->matric_no = $this->matric_no;
			$assoc->pro_study = $this->pro_study;
			$assoc->cumm_sem = $this->cumm_sem;
			$assoc->phone = $this->phone;
			$assoc->sv_main= $this->sv_main;
			$assoc->sv_co1= $this->sv_co1;
			$assoc->sv_co2= $this->sv_co2;
			$assoc->sv_co3= $this->sv_co3;
			if($assoc->save()){
				Yii::$app->session->setFlash(
				'info',
				Yii::t(
					'user',
						'Your account has been created and a message with further instructions has been sent to your email'
					)
				);
			}else{
			    $assoc->flashError();
			    return false;
			    
			}
        }else{
            $user->flashError();
			return false;
		}
		

		
		
		

        

        return true;
    }
	
	public function defaultTitle(){
		return Associate::defaultTitle();
	}


}
