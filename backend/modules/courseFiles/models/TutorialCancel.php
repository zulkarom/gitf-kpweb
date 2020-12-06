<?php

namespace backend\modules\courseFiles\models;

use Yii;

/**
 * This is the model class for table "cf_tut_cancel_class".
 *
 * @property int $id
 * @property int $tutorial_id
 * @property string $uploaded_file
 */
class TutorialCancel extends \yii\db\ActiveRecord
{
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
            [['id', 'tutorial_id', 'uploaded_file'], 'required'],
            [['id', 'tutorial_id'], 'integer'],
            [['uploaded_file'], 'string'],
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
            'uploaded_file' => 'Uploaded File',
        ];
    }
}
