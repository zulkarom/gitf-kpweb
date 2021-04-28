<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $curr_page
 * @property string $p_1
 * @property string $p_2
 * @property string $p_3
 * @property string $p_4
 * @property string $p_5
 * @property string $p_6
 * @property string $p_7
 * @property string $p_8
 * @property string $p_9
 * @property string $p_10
 * @property string $p_11
 * @property string $p_12
 * @property string $p_13
 * @property string $p_14
 * @property string $p_15
 * @property string $p_16
 * @property string $p_17
 * @property string $p_18
 * @property string $p_19
 * @property string $p_20
 * @property string $p_21
 * @property string $p_22
 * @property string $p_23
 * @property string $p_24
 * @property string $p_25
 * @property string $p_26
 * @property string $p_27
 * @property string $p_28
 * @property string $p_29
 */
class Page extends \yii\db\ActiveRecord
{
	public $total_page = 34;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['curr_page', 'user_id', 'p_1', 'p_2', 'p_3', 'p_4', 'p_5', 'p_6', 'p_7', 'p_8', 'p_9', 'p_10', 'p_11', 'p_12', 'p_13', 'p_14', 'p_15', 'p_16', 'p_17', 'p_18', 'p_19', 'p_20', 'p_21', 'p_22', 'p_23', 'p_24', 'p_25', 'p_26', 'p_27', 'p_28', 'p_29', 'p_30', 'p_31', 'p_32', 'p_33', 'p_34'], 'required', 'on' => 'signup'],
		
            [['curr_page'], 'required', 'on' => 'answer'],
			
            [['customer_id'], 'integer'],
            [['curr_page'], 'integer', 'max' => 35],
			
            [['p_1', 'p_2', 'p_3', 'p_4', 'p_5', 'p_6', 'p_7', 'p_8', 'p_9', 'p_10', 'p_11', 'p_12', 'p_13', 'p_14', 'p_15', 'p_16', 'p_17', 'p_18', 'p_19', 'p_20', 'p_21', 'p_22', 'p_23', 'p_24', 'p_25', 'p_26', 'p_27', 'p_28', 'p_29', 'p_30', 'p_31', 'p_32', 'p_33', 'p_34'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'curr_page' => 'Curr Page',
            'p_1' => 'P 1',
            'p_2' => 'P 2',
            'p_3' => 'P 3',
            'p_4' => 'P 4',
            'p_5' => 'P 5',
            'p_6' => 'P 6',
            'p_7' => 'P 7',
            'p_8' => 'P 8',
            'p_9' => 'P 9',
            'p_10' => 'P 10',
            'p_11' => 'P 11',
            'p_12' => 'P 12',
            'p_13' => 'P 13',
            'p_14' => 'P 14',
            'p_15' => 'P 15',
            'p_16' => 'P 16',
            'p_17' => 'P 17',
            'p_18' => 'P 18',
            'p_19' => 'P 19',
            'p_20' => 'P 20',
            'p_21' => 'P 21',
            'p_22' => 'P 22',
            'p_23' => 'P 23',
            'p_24' => 'P 24',
            'p_25' => 'P 25',
            'p_26' => 'P 26',
            'p_27' => 'P 27',
            'p_28' => 'P 28',
            'p_29' => 'P 29',
			'p_30' => 'P 30',
			'p_31' => 'P 31',
			'p_32' => 'P 32',
			'p_33' => 'P 33',
			'p_34' => 'P 34',
        ];
    }
	
	public function getCustomer(){
		return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
	}
	
	
}
