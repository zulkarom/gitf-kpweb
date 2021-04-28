<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_date_name".
 *
 * @property int $id
 * @property string $date_name
 */
class ConfDateName extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_date_name';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_name'], 'required'],
            [['date_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_name' => 'Date Name',
        ];
    }
}
