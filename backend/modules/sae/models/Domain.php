<?php

namespace backend\modules\sae\models;

use Yii;

/**
 * This is the model class for table "psy_domain".
 *
 * @property int $id
 * @property int $bat_id
 * @property int $grade_cat
 */
class Domain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'psy_domain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bat_id', 'grade_cat'], 'required'],
            [['bat_id', 'grade_cat'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bat_id' => 'Bat ID',
            'grade_cat' => 'Grade Cat',
        ];
    }
	
	public function getCategory(){
         return $this->hasOne(GradeCategory::className(), ['id' => 'grade_cat']);
    }

	
	
}
