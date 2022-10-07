<?php

namespace confsite\models\user;

use backend\modules\conference\models\Associate;
use common\models\User as ModelsUser;
use Yii;
use yii\helpers\Html;

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
	
	public function flashError(){
	    if($this->getErrors()){
	        foreach($this->getErrors() as $error){
	            if($error){
	                foreach($error as $e){
	                    \Yii::$app->session->addFlash('error', $e);
	                }
	            }
	        }
	    }
	    
	}

	public static function checkProfile($confurl){
		$user = ModelsUser::findOne(Yii::$app->user->identity->id);
		$associate = $user->associate;
			
			if(!$associate){
			    $new = new Associate();
			    $new->scenario = 'raw';
			    $new->user_id = $user->id;
			    if(!$new->save()){
					print_r($new->getErrors());
					die();
				}
			}
		
		$add = $associate->assoc_address;
		$inst = $associate->institution;
		$phone = $associate->phone;
		if(!$add || !$inst || !$phone){
			return false;
		}

		return true;
	}
	
	
}


?>