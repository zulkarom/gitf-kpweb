<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_fee".
 *
 * @property int $id
 * @property int $conf_id
 * @property string $fee_name
 * @property string $fee_amount
 * @property string $fee_early
 * @property string $valid_until
 * @property int $minimum_paper
 * @property int $fee_order
 */
class ConfFee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_fee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fee_name', 'fee_amount', 'fee_early', 'fee_currency'], 'required'],
			
			
            [['conf_id', 'minimum_paper', 'fee_order'], 'integer'],
			
            [['fee_amount', 'fee_early'], 'number'],
			
            [['valid_until'], 'safe'],
			
            [['fee_name'], 'string', 'max' => 200],
			[['fee_currency'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conf_id' => 'Conf ID',
            'fee_name' => 'Fee Name',
            'fee_amount' => 'Fee Amount',
            'fee_early' => 'Fee Early',
            'valid_until' => 'Valid Until',
            'minimum_paper' => 'Minimum Paper',
            'fee_order' => 'Fee Order',
        ];
    }

    public function getFeeText(){
        $amt = $this->fee_amount + 0;
        return $this->fee_name . ' ' . $this->fee_currency . $amt;
    }
}
