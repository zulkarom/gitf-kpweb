<?php

namespace backend\modules\manual\models;

use Yii;

/**
 * This is the model class for table "mnl_title".
 *
 * @property int $id
 * @property int $section_id
 * @property string $title_text
 */
class Title extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mnl_title';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['section_id'], 'required'],
            [['section_id'], 'integer'],
            [['title_text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_id' => 'Section ID',
            'title_text' => 'Title Text',
        ];
    }
}
