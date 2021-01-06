<?php

namespace backend\modules\teachingLoad\models;

use Yii;


/**
 * This is the model class for table "tld_tem_autoload".
 *
 * @property int $id
 * @property int $staff_id
 * @property string $running_name
 * @property int $load_hour
 * @property int $stop_run
 */
class TemAutoload extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_tem_autoload';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id'], 'required'],
            [['staff_id', 'load_hour', 'stop_run'], 'integer'],
            [['running_name'], 'string', 'max' => 100],
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
            'running_name' => 'Running Name',
            'load_hour' => 'Load Hour',
            'stop_run' => 'Stop Run',
        ];
    }
	
	public function getStaff(){
         return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

}
