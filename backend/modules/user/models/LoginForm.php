<?php
namespace  backend\modules\user\models;

use dektrium\user\models\LoginForm as BaseLoginForm;
use backend\modules\staff\models\Staff;
/**
 * Login form
 */
class LoginForm extends BaseLoginForm
{
	
	public function rules()
    {
        $rules = parent::rules();
		
		$rules['loginLength']  = ['login', 'string'];

        return $rules;
    }
	
	public function attributeLabels()
    {
		$labels = parent::attributeLabels();
		$labels['login'] = 'Staff No.';
        return $labels;
    }
	
	public function login(){
		if(parent::login()){
			$staff = Staff::findOne(['user_id' => $this->user->id]);
			if($staff){
				return true;
			}else{
				\Yii::$app->user->logout();
				$this->addError('password', \Yii::t('user', 'Access Denied'));
				return false;
			}
		}else{
			return false;
		}
	}
	

	
	
}
