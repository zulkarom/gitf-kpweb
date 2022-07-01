<?php

namespace backend\modules\sae\models;

use Yii;
use backend\modules\sae\models\Common;
/**
 * This is the model class for table "psy_batch".
 *
 * @property int $bat_id
 * @property string $bat_text
 */
class Batch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'psy_batch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bat_text'], 'required'],
            [['bat_text'], 'string', 'max' => 100],
            [['column1', 'column2', 'column3', 'column4'], 'string', 'max' => 225],
            [['bat_show', 'allow_register','allow_update', 'is_open', 'result_limit', 'point_min', 'point_min_total'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Bat ID',
            'bat_text' => 'Batch',
            'bat_show' => 'Default',
            'is_open' => 'Open to Answer',
            'allow_register' => 'Allow Registration',
            'allow_update' => 'Participant Update Information',
            'column1' => 'Custom 1',
            'column2' => 'Custom 2',
            'column3' => 'Custom 3',
            'column4' => 'Custom 4'
        ];
    }

    public static function countBatches(){
        return self::find()
        ->count();
    }

    public function getShowText(){
        return Common::showing()[$this->bat_show];
    }

    public function getAllowText(){
        return Common::showing()[$this->allow_register];
    }
    
    public function getAllowUpdateText(){
        return Common::showing()[$this->allow_update];
    }
    
    public function getOpenText(){
        return Common::showing()[$this->is_open];
    }

    public function getAnswer()
    {
        return $this->hasOne(Batch::className(), ['id' => 'can_batch']);
    }

    public static function defaultBatch()
    {
        $query = self::find()
        ->where(['bat_show' => 1])
        ->one();

        return $query->bat_text;
    }
}
