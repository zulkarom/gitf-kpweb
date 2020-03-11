<?php

namespace backend\modules\questbank\models;

use Yii;

/**
 * This is the model class for table "qb_question".
 *
 * @property int $id
 * @property int $course_id
 * @property int $qtype_id
 * @property string $qtext
 * @property string $qtext_bi
 * @property int $category_id
 * @property string $created_at
 * @property string $updated_at
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qb_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id', 'qtype_id', 'qtext', 'qtext_bi', 'category_id'], 'required'],
			
            [['id', 'course_id', 'qtype_id', 'category_id', 'level'], 'integer'],
			
            [['qtext', 'qtext_bi'], 'string'],
			
            [['created_at', 'updated_at'], 'safe'],
			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course',
            'qtype_id' => 'Type',
            'qtext' => 'Question Text (BM)',
            'qtext_bi' => 'Question Text (EN)',
            'category_id' => 'Category',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }
	
	public function getCategory()
    {
        return $this->hasOne(QuestionCat::className(), ['id' => 'category_id']);
    }
	
	public function getCategoryList()
    {
        return $this->hasMany(QuestionCat::className(), ['course_id' => 'course_id']);
    }
	
	public function getOptions()
    {
        return $this->hasMany(QuestionOption::className(), ['question_id' => 'id']);
    }
	
	public function getQuestionType()
    {
        return $this->hasOne(QuestionType::className(), ['id' => 'qtype_id']);
    }
	
	public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }


}
