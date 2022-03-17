<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_semester_module".
 *
 * @property int $id
 * @property int $student_sem_id
 * @property int $module_id
 */
class SemesterModule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_semester_module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_sem_id', 'module_id'], 'required'],
            [['student_sem_id', 'module_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_sem_id' => 'Student Sem ID',
            'module_id' => 'Module ID',
        ];
    }
    
    public function getModule(){
         return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }

}
