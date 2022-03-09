<?php

namespace backend\modules\manual\models;

use Yii;

/**
 * This is the model class for table "mnl_step".
 *
 * @property int $id
 * @property int $item_id
 * @property string $step_text
 */
class Step extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mnl_step';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'step_text'], 'required'],
            [['item_id'], 'integer'],
            [['step_text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'step_text' => 'Step Text',
        ];
    }
}
