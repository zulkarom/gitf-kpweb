<?php

namespace backend\modules\courseFiles\models;

use Yii;

/**
 * This is the model class for table "cf_lec_cancel_class".
 *
 * @property int $id
 * @property int $lecture_id
 * @property string $path_file
 */
class LectureCancel extends \yii\db\ActiveRecord
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
            [['path_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, png, jpg, gif', 'maxSize' => 5000000],

            [['id', 'lecture_id'], 'required'],
            [['id', 'lecture_id'], 'integer'],
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
}
