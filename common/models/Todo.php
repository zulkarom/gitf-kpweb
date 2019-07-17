<?php

/**
 *  this class specifically create to temporarily handle Yii::$app->user->can() problem
 * since Yii::$app->authManager->getRolesByUser($id) is ok, we make use of this function to copy the function of Yii::$app->user->can()
 */

namespace common\models;

use Yii;

class Todo
{
	public static function can($access){
		$id = Yii::$app->user->identity->id;
		$auth = Yii::$app->authManager;
		if($auth){
			$roles = $auth->getRolesByUser($id);
			if($roles){
				foreach($roles as $r){
					if($r->name == $access){
						return true;
					}
				}
			}
		}
		
		
		return false;
	}

}