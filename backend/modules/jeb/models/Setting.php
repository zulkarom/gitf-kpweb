<?php

namespace backend\modules\jeb\models;

use Yii;

/**
 * This is the model class for table "jeb_setting".
 *
 * @property int $id
 * @property string $template_file
 */
class Setting extends \yii\db\ActiveRecord
{
	public $template_instance;
	
	//this for local
	public static $frontUrl = './../../frontend/web/';
	
	//ensure to use this on production
	//public static $frontUrl = '../';
	
	public $file_controller;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeb_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['template_file'], 'required'],
			
            [['template_file'], 'string', 'max' => 100],
			
			[['template_file'], 'required', 'on' => 'template_upload'],
            [['template_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx, pdf', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'template_delete'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_file' => 'Template File',
        ];
    }
}
