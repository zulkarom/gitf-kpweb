<?php

namespace backend\modules\aduan\models;

use Yii;

/**
 * This is the model class for table "adu_aduan_topic".
 *
 * @property int $id
 * @property string $topic_name
 */
class AduanTopic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adu_aduan_topic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topic_name'], 'required'],
            [['topic_name'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic_name' => 'Topic Name',
        ];
    }

    
}
