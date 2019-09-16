<?php

namespace backend\modules\jeb\models;

use Yii;

/**
 * This is the model class for table "jeb_review_form".
 *
 * @property int $id
 * @property string $form_quest
 */
class ReviewForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeb_review_form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_quest'], 'required'],
            [['form_quest'], 'string'],
        ];
    }

    /**
     * @inheritdoc
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
		0 => 'In Progress',
		1 => 'Do not accept for publication.',
		2 => 'Ask for major revisions and allow to again be reviewed if re-submitted.',
		3 => 'Ask for revisions and continue with a second review.',
		4 => 'Accept with minor revisions.',
		5 => 'Accept as written with no need for any revisions.'
		];
	}
}
