<?php

namespace backend\modules\staff\models;

use Yii;

/**
 * This is the model class for table "staff_education".
 *
 * @property int $id
 * @property int $edu_staff
 * @property int $edu_level
 * @property string $edu_qualification
 * @property string $edu_institution
 * @property string $edu_year
 *
 * @property Staff $eduStaff
 */
class StaffEducation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_education';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edu_staff', 'edu_level', 'edu_qualification', 'edu_institution', 'edu_year'], 'required'],
            [['edu_staff', 'edu_level'], 'integer'],
            [['edu_year'], 'safe'],
            [['edu_qualification', 'edu_institution'], 'string', 'max' => 150],
            [['edu_staff'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['edu_staff' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'edu_staff' => 'Staff',
            'edu_level' => 'Level',
            'edu_qualification' => 'Qualification',
            'edu_institution' => 'Institution',
            'edu_year' => 'Year',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'edu_staff']);
    }
	
	 public function getLevel()
    {
        return $this->hasOne(StaffEduLevel::className(), ['id' => 'edu_level']);
    }
}
