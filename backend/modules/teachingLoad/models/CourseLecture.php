<?php

namespace backend\modules\teachingLoad\models;

use Yii;

/**
 * This is the model class for table "tld_course_lec".
 *
 * @property int $id
 * @property int $offered_id
 * @property string $lec_name
 * @property string $created_at
 * @property string $updated_at
 */
class CourseLecture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_course_lec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['offered_id', 'created_at', 'updated_at'], 'required'],
			
            [['offered_id', 'student_num'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['lec_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'offered_id' => 'Offered ID',
            'lec_name' => 'Lec Name',
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

    public function getTutorials()
        {
            return $this->hasMany(TutorialLecture::className(), ['lecture_id' => 'id']);
        }

    public function getLecturers()
    {
        return $this->hasMany(LecLecturer::className(), ['lecture_id' => 'id']);
    }

}
