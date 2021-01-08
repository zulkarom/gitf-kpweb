<?php
namespace backend\modules\courseFiles\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class AddMaterialForm extends Model
{
    public $material_number;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_number'], 'required'],
			[['material_number'], 'integer'],
        ];
    }
	


}
