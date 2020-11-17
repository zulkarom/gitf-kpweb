<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\teachingLoad\models\TutorialTutor;
use backend\modules\teachingLoad\models\CourseLecture;
/**
 * This is the model class for table "tld_tutorial_lec".
 *
 * @property int $id
 * @property int $lecture_id
 * @property string $tutorial_name
 * @property int $student_num
 * @property string $created_at
 * @property string $updated_at
 */
class TutorialLecture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_tutorial_lec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lecture_id', 'created_at', 'updated_at'], 'required'],
            [['lecture_id', 'student_num'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['tutorial_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lecture_id' => 'Lecture ID',
            'tutorial_name' => 'Tutorial Name',
            'student_num' => 'Student Num',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

    public function getLecturers()
    {
        return $this->hasMany(TutorialTutor::className(), ['tutorial_id' => 'id']);
    }

    //16.11.2020
    public function getLecture(){
        return $this->hasOne(CourseLecture::className(), ['id' => 'lecture_id']);
    }
}
