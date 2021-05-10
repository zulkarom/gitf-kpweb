<?php

namespace confsite\models;

use Yii;

/**
 * This is the model class for table "jeb_associate".
 *
 * @property int $id
 * @property int $user_id
 * @property string $institution
 * @property int $country_id
 * @property int $admin_creation
 * @property string $title
 * @property string $assoc_address
 * @property string $phone
 */
class Associate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jeb_associate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'institution', 'country_id', 'admin_creation'], 'required'],
            [['user_id', 'country_id', 'admin_creation'], 'integer'],
            [['institution'], 'string', 'max' => 200],
            [['title', 'phone'], 'string', 'max' => 100],
            [['assoc_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'institution' => 'Institution',
            'country_id' => 'Country ID',
            'admin_creation' => 'Admin Creation',
            'title' => 'Title',
            'assoc_address' => 'Assoc Address',
            'phone' => 'Phone',
        ];
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
