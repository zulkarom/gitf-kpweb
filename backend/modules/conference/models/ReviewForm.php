<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_review_form".
 *
 * @property int $id
 * @property string $form_quest
 */
class ReviewForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_review_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'form_quest'], 'required'],
            [['id'], 'integer'],
            [['form_quest'], 'string'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_quest' => 'Form Quest',
        ];
    }
	
	public static function reviewOptions(){
		return [
		2 => 'Strong Accept',
		1 => 'Accept',
		0 => 'Borderline',
		-1 => 'Reject',
		-2 => 'Strong Reject'
		];
	}
}