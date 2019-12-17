<?php

namespace backend\modules\proceedings\models;

use Yii;

/**
 * This is the model class for table "proceeding".
 *
 * @property int $id
 * @property string $proc_name
 * @property string $date_start
 * @property string $date_end
 * @property string $image_file
 */
class Proceeding extends \yii\db\ActiveRecord
{
	public $image_instance;
	public $file_controller;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proceeding';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proc_name', 'date_start', 'date_end'], 'required'],
			
            [['date_start', 'date_end'], 'safe'],
			
            [['image_file', 'proc_url'], 'string'],
			
            [['proc_name'], 'string', 'max' => 200],
			
			[['image_file'], 'required', 'on' => 'image_upload'],
            [['image_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'image_delete'],
			
			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proc_name' => 'Procedings Name',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'image_file' => 'Image File',
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

}
