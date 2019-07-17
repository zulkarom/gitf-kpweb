<?php

namespace backend\modules\website\models;

use Yii;

/**
 * This is the model class for table "web_front_slider".
 *
 * @property int $id
 * @property string $image_file
 * @property string $caption
 */
class FrontSlider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_front_slider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_file', 'caption'], 'required'],
            [['image_file', 'caption'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_file' => 'Image File',
            'caption' => 'Caption',
        ];
    }
}
