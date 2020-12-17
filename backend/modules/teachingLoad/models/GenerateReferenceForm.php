<?php
namespace backend\modules\teachingLoad\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class GenerateReferenceForm extends Model
{
    public $ref_letter;
    public $start_number;
    public $date;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ref_letter', 'start_number', 'date'], 'required'],
            [['start_number'], 'integer'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ref_letter' => 'Rujukan Surat',
            'start_number' => 'Bermula dari',
            'date' => 'Tarikh',
        ];
    }

}
