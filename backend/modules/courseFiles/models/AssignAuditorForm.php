<?php
namespace backend\modules\courseFiles\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class AssignAuditorForm extends Model
{
    public $staff_id;
	public $selection;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_id'], 'required'],
			[['staff_id'], 'integer'],
			['selection', 'each', 'rule' => ['integer', 'skipOnEmpty' => false]],
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'staff_id' => 'Auditor',
        ];
    }
	


}
