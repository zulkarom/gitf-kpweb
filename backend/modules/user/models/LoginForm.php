<?php
namespace  backend\modules\user\models;;

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
	

	
	
}
