<?php

namespace backend\modules\courseFiles\models;

use Yii;
use backend\modules\teachingLoad\models\CourseLecture;

/**
 * This is the model class for table "cf_lec_cancel_class".
 *
 * @property int $id
 * @property int $lecture_id
 * @property string $path_file
 */
class LectureCancelFile extends \yii\db\ActiveRecord
{

    public $file_controller;
    public $path_instance;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cf_lec_cancel_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            //path upload///
            [['path_file'], 'required', 'on' => 'path_upload'],
            [['path_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            
            [['lecture_id', 'updated_at'], 'required', 'on' => 'add_cancel'],

            [['lecture_id'], 'required'],
            [['lecture_id'], 'integer'],
            [['path_file'], 'string'],
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
            'path_file' => 'Path File',
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

    public function getLecture(){
        return $this->hasOne(CourseLecture::className(), ['id' => 'lecture_id']);
    }
}
