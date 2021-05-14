<?php
namespace confsite\models\user;

use dektrium\user\models\LoginForm as BaseLoginForm;

/**
 * Login form
 */
class LoginForm extends BaseLoginForm
{
	
	public function rules()
    {
        $rules = parent::rules();
		
		$rules['loginLength']  = ['login', 'email'];

        return $rules;
    }
	
	public function attributeLabels()
    {
		$labels = parent::attributeLabels();
		$labels['login'] = 'Email';
        return $labels;
    }
	
	public function login(){
		
		if(parent::login()){
			if(true){
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
