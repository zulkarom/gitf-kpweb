<?php

namespace backend\modules\questbank\models;

use Yii;

/**
 * This is the model class for table "qb_question_option".
 *
 * @property int $id
 * @property int $question_id
 * @property string $option_text
 * @property string $option_text_bi
 * @property int $is_answer
 */
class QuestionOption extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qb_question_option';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['option_text', 'option_text_bi', 'is_answer'], 'required'],
            [['id', 'question_id', 'is_answer'], 'integer'],
            [['option_text', 'option_text_bi'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'option_text' => 'Option Text',
            'option_text_bi' => 'Option Text Bi',
            'is_answer' => 'Is Answer',
        ];
    }
}
