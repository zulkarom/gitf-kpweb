<?php
namespace backend\modules\courseFiles\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class AddFileForm extends Model
{
    public $file_number;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_number'], 'required'],
			[['file_number'], 'integer'],
        ];
    }
	


}
