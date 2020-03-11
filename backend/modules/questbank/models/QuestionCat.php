<?php

namespace backend\modules\questbank\models;

use Yii;

/**
 * This is the model class for table "qb_question_cat".
 *
 * @property int $id
 * @property int $course_id
 * @property string $cat_text
 */
class QuestionCat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qb_question_cat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id', 'cat_text'], 'required'],
            [['id', 'course_id'], 'integer'],
            [['cat_text'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'cat_text' => 'Cat Text',
        ];
    }
}
