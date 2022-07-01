<?php

namespace backend\modules\sae\models;

use Yii;

/**
 * This is the model class for table "psy_question_cat".
 *
 * @property int $cat_id
 * @property string $cat_text
 * @property string|null $cat_text_bi
 */
class QuestionCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'psy_question_cat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_text'], 'required'],
            [['cat_text'], 'string', 'max' => 200],
            [['cat_text_bi'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Cat ID',
            'cat_text' => 'Cat Text',
            'cat_text_bi' => 'Cat Text Bi',
        ];
    }
}
