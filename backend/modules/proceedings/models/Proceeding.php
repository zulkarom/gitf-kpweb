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
            [['proc_name', 'date_start', 'date_end', 'image_file'], 'required'],
            [['date_start', 'date_end'], 'safe'],
            [['image_file'], 'string'],
            [['proc_name'], 'string', 'max' => 200],
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
}
