<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\teachingLoad\models\TutorialLecture;
use backend\modules\staff\models\Staff;


/**
 * This is the model class for table "tutorial_tutor".
 *
 * @property int $id
 * @property int $tutorial_id
 * @property int $staff_id
 */
class TutorialTutor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_tutorial_tutor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tutorial_id'], 'required'],
            [['tutorial_id', 'staff_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tutorial_id' => 'Tutorial ID',
            'staff_id' => 'Staff ID',
        ];
    }

     public function getTutorialLec(){
        return $this->hasOne(TutorialLecture::className(), ['id' => 'tutorial_id']);
    }
	
	public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
	
	
}
