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
    public $date;
    public $number_of_class;

    /**
     * @inheritdoc
     */
     public function rules()
    {
        return [
            [['date','number_of_class'], 'required'],
            [['number_of_class'], 'integer'],
            [['date'], 'safe'],
        ];
    }
    
	


}
