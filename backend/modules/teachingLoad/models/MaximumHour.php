<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\staff\models\Staff;

/**
 * This is the model class for table "tld_max_hour".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $max_hour
 */
class MaximumHour extends \yii\db\ActiveRecord
{
    public $staff;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_max_hour';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id'], 'required'],
            [['staff_id', 'max_hour'], 'integer'],
            [['staff'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'max_hour' => 'Max Hour',
        ];
    }

    public function getstaff(){
        return Staff::find()
        ->where(['id' => 'staff_id'])
        ->all();
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

   

   

}
