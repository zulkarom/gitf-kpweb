<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_download".
 *
 * @property int $id
 * @property int $conf_id
 * @property string $download_name
 * @property string $download_file
 * @property int $download_order
 *
 * @property Conference $conf
 */
class ConfDownload extends \yii\db\ActiveRecord
{
	public $download_instance;
	
	public $file_controller;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_download';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
		
			[['conf_id' ], 'required', 'on' => 'create'],
			
            [['download_name' ], 'required', 'on' => 'savefile'],
			
            [['conf_id', 'download_order'], 'integer'],
			
            [['download_file'], 'string'],
            [['download_name'], 'string', 'max' => 200],
            [['conf_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conference::className(), 'targetAttribute' => ['conf_id' => 'id']],
			
			[['download_file'], 'required', 'on' => 'download_upload'],
            [['download_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx, pdf, jpg, png', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'download_delete'],
			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conf_id' => 'Conf ID',
            'download_name' => 'Download Name',
            'download_file' => 'Download File',
            'download_order' => 'Download Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConference()
    {
        return $this->hasOne(Conference::className(), ['id' => 'conf_id']);
    }
}
