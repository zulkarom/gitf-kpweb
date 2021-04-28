<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_email_tmplt_set".
 *
 * @property int $id
 * @property string $title
 * @property string $subject
 * @property string $content
 */
class EmailSet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_email_tmplt_set';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'subject', 'content'], 'required'],
            [['content'], 'string'],
            [['title', 'subject'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'subject' => 'Subject',
            'content' => 'Content',
        ];
    }
}
