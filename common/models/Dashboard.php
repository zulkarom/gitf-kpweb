<?php

namespace common\models;

use backend\modules\erpd\models\Research;
/**
 * Class Menu
 * Theme menu widget.
 */
class Dashboard
{
	public static function countMyResearch(){
		$kira = Research::find()
		->joinWith('researchers')
		->where(['staff_id' => Yii::$app->user->identity->staff->id, 'status' => 50])
		->count();
	}
}
