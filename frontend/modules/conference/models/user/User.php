<?php

namespace frontend\modules\conference\models\user; 

class User extends \dektrium\user\models\User
{
	const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
	

    public function rules()
    {
        $rules = parent::rules();
		$rules['fullnameRequired'] = ['fullname', 'required', 'on' => ['register', 'create', 'connect', 'update']];
        
        return $rules;
    }
	

	
	public function register(){
		$this->status = self::STATUS_ACTIVE;
		return parent::register();
	}
}

?>