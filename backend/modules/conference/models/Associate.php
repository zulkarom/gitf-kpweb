<?php

namespace backend\modules\conference\models;

use Yii;
use common\models\User;
use common\models\Country;

/**
 * This is the model class for table "jeb_associate".
 *
 * @property int $id
 * @property int $user_id
 */
class Associate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeb_associate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['user_id', 'country_id', 'institution'], 'required'],
			
			[['institution', 'country_id', 'title'], 'required', 'on' => 'update_external'],
			
            [['user_id', 'country_id'], 'integer'],
			
			[['title'], 'string', 'max' => 100],
			
            [['institution'], 'string', 'max' => 200],
			
			[['assoc_address', 'phone'], 'string'],
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
            'country_id' => 'Country',
			'institution' => 'Institution',
        ];
    }
	
	public function getUser(){
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
	
	public function getCountry(){
		return $this->hasOne(Country::className(), ['id' => 'country_id']);
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
	
	public static function defaultTitle(){
		$array = ['Mr.','Mrs.', 'Miss','Dr.', 'Assoc. Prof.', 'Prof.'];
		$return = [];
		foreach($array as $a){
			$return[$a] = $a;
		}
		$return[999] = 'Others (Please specify...)';
		return $return;
	}

}
