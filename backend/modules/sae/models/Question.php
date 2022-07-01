<?php

namespace backend\modules\sae\models;

use Yii;

/**
 * This is the model class for table "psy_question".
 *
 * @property int $que_id
 * @property string|null $que_text
 * @property string|null $que_text_bi
 * @property int|null $display_cat
 * @property int|null $grade_cat
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'psy_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['display_cat', 'grade_cat'], 'integer'],
            [['que_text'], 'string', 'max' => 200],
            [['que_text_bi'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'que_id' => 'Que ID',
            'que_text' => 'Question Text',
            'que_text_bi' => 'Question Text En',
            'display_cat' => 'Instruction',
            'grade_cat' => 'Domain',
        ];
    }

    public static function getAllQuestions()
    {
        $query = self::find()
        ->alias('a')
        ->select('a.que_id, a.que_text, a.que_text_bi, b.cat_text, b.cat_text_bi')
        ->joinWith('questionCategory b')
        ->all();
        return $query;
    }

    // public static function getAllQuestions()
    // {
    //     $database = DatabaseFactory::getFactory()->getConnection();

    //     $sql = "SELECT a.que_id, a.que_text, a.que_text_bi, b.cat_text, b.cat_text_bi
    //     FROM psy_question as a
    //     INNER JOIN psy_question_cat as b
    //     ON a.display_cat = b.cat_id
    //     ";
    //     $query = $database->prepare($sql);
    //     $query->execute();
    //     return $query->fetchAll();
    // }
    
    public function getGradeCategory()
    {
        return $this->hasOne(GradeCategory::className(), ['id' => 'grade_cat']);
    }

    public function getQuestionCategory()
    {
        return $this->hasOne(QuestionCategory::className(), ['cat_id' => 'display_cat']);
    }
}
