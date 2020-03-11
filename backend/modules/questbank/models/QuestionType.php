<?php

namespace backend\modules\questbank\models;

use Yii;

/**
 * This is the model class for table "qb_question_type".
 *
 * @property int $id
 * @property string $code
 * @property string $code_text
 */
class QuestionType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qb_question_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'code_text'], 'required'],
            [['code'], 'string', 'max' => 20],
            [['code_text'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'code_text' => 'Code Text',
        ];
    }
}
