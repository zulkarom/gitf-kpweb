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
	public $program_search;
	public $action;
    public $program_id;
    public $is_audited;
    public $prg_overall;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['semester_id', 'program_search', 'program_id', 'is_audited', 'status'], 'integer'],
			[['prg_overall'], 'number'],
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
