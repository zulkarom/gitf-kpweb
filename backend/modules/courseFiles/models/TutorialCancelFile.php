<?php

namespace backend\modules\courseFiles\models;

use Yii;
use backend\modules\teachingLoad\models\TutorialLecture;

/**
 * This is the model class for table "cf_lec_cancel_class".
 *
 * @property int $id
 * @property int $lecture_id
 * @property string $path_file
 */
class TutorialCancelFile extends \yii\db\ActiveRecord
{

    public $file_controller;
    public $path_instance;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cf_tut_cancel_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_name', 'path_file'], 'required', 'on' => 'saveall'],
            //path upload///
            [['path_file'], 'required', 'on' => 'path_upload'],
            [['path_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            
            [['tutorial_id', 'updated_at'], 'required', 'on' => 'add_cancel'],

            [['tutorial_id'], 'required'],
			[['date_old', 'date_new'], 'safe'],
            [['tutorial_id'], 'integer'],
            [['path_file', 'file_name'], 'string'],
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

    public function getTutorial(){
        return $this->hasOne(TutorialLecture::className(), ['id' => 'tutorial_id']);
    }
}
