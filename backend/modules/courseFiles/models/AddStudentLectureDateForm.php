<?php
namespace backend\modules\courseFiles\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class AddStudentLectureDateForm extends Model
{
    public $start_date;
	public $exclude_date;
    public $number_of_class;

    /**
     * @inheritdoc
     */
     public function rules()
    {
        return [
            [['start_date','number_of_class'], 'required'],
            [['number_of_class'], 'integer'],
            [['start_date', 'exclude_date'], 'safe'],
        ];
    }
    
	


}
