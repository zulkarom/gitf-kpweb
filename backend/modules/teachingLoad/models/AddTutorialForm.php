<?php
namespace backend\modules\teachingLoad\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class AddTutorialForm extends Model
{
    public $tutorial_number;
    public $lecture_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tutorial_number','lecture_id'], 'required'],
			[['tutorial_number','lecture_id'], 'integer'],
        ];
    }
	


}
