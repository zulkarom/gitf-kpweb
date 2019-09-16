<?php

namespace backend\modules\jeb\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "jeb_user_scope".
 *
 * @property int $id
 * @property int $user_id
 * @property int $scope_id
 */
class UserScope extends \yii\db\ActiveRecord
{
	public $fullname;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeb_user_scope';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'scope_id'], 'required'],
            [['user_id', 'scope_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'scope_id' => 'Scope ID',
        ];
    }
	
	public function getScope(){
        return $this->hasOne(ArticleScope::className(), ['id' => 'scope_id']);
    }
	
	public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	
	public static function listReviewers($scope, $inex){
		$reviewers = [];
		
		if($inex == 1){
			$reviewers =  self::find()
			->innerJoin('auth_assignment', 'auth_assignment.user_id = jeb_user_scope.user_id' )
			->innerJoin('staff', 'staff.user_id = jeb_user_scope.user_id' )
			->where(['scope_id' => $scope, 'auth_assignment.item_name' => 'jeb-reviewer'])
			->all();
		}else if($inex == 2){
			$reviewers =  self::find()
			->innerJoin('auth_assignment', 'auth_assignment.user_id = jeb_user_scope.user_id' )
			->innerJoin('jeb_associate', 'jeb_associate.user_id = jeb_user_scope.user_id' )
			->where(['scope_id' => $scope, 'auth_assignment.item_name' => 'jeb-reviewer'])
			->all();
		}else{
			$reviewers =  self::find()
			->innerJoin('auth_assignment', 'auth_assignment.user_id = jeb_user_scope.user_id' )
			->where(['scope_id' => $scope, 'auth_assignment.item_name' => 'jeb-reviewer'])
			->all();
		}
		
		
		$arr = [];
		
		if($reviewers){
			foreach($reviewers as $reviewer){
				$arr[$reviewer->user_id] = $reviewer->user->fullname;
			}
		}
		
		return $arr;
	}
	


}
