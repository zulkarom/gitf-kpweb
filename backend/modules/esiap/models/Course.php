<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course".
 *
 * @property int $id
 * @property string $crs_code
 * @property string $crs_name
 * @property string $crs_name_bi
 * @property int $credit_hour
 * @property int $crs_type
 * @property int $crs_level
 * @property int $faculty
 * @property int $department
 * @property int $program
 * @property int $is_dummy
 * @property int $trash
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crs_code', 'crs_name', 'crs_name_bi', 'credit_hour', 'crs_type', 'crs_level'], 'required'],
			
            [['credit_hour', 'crs_type', 'crs_level', 'faculty', 'department', 'program', 'is_dummy', 'trash'], 'integer'],
            [['crs_code'], 'string', 'max' => 10],
            [['crs_name', 'crs_name_bi'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'crs_code' => 'Course Code',
            'crs_name' => 'Course Name (BM)',
            'crs_name_bi' => 'Course Name (EN)',
            'credit_hour' => 'Credit Hour',
            'crs_type' => 'Course Type',
            'crs_level' => 'Course Level',
            'faculty' => 'Faculty',
            'department' => 'Department',
            'program' => 'Program',
            'is_dummy' => 'Is Dummy',
            'trash' => 'Trash',
        ];
    }
}
