<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class SemesterForm extends Model
{
    public $semester_id;
	public $str_search;
	public $action;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['semester_id'], 'integer'],
			[['str_search'], 'string'],
        ];
    }
	
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'semester_id' => 'Select Semester',
        ];
    }
	
	public function getSemester(){
		return Semester::findOne($this->semester_id);
	}

}
