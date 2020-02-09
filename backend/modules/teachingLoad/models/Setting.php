<?php

namespace backend\modules\teachingLoad\models;

use Yii;

/**
 * This is the model class for table "tld_setting".
 *
 * @property int $id
 * @property string $date_start
 * @property string $date_end
 * @property string $updated_at
 * @property int $updated_by
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_start', 'date_end', 'updated_at', 'updated_by'], 'required'],
            [['date_start', 'date_end', 'updated_at'], 'safe'],
            [['updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
	
	public function getFormAccess(){
		$start = strtotime($this->date_start);
		$end = strtotime($this->date_end);
		$open = false;
		
		if(time() >= $start and time() <= $end){
			$open = true;
		}
		
		return $open;
	}
}
