<?php
namespace backend\modules\teachingLoad\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class AddLectureForm extends Model
{
    public $lecture_number;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lecure_number'], 'required'],
			[['lecture_number'], 'integer'],
        ];
    }
	


}
