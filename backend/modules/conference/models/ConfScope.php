<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_scope".
 *
 * @property int $id
 * @property int $conf_id
 * @property string $scope_name
 */
class ConfScope extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_scope';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['conf_id', 'scope_name'], 'required'],
            [['conf_id'], 'integer'],
            [['scope_name'], 'string', 'max' => 200],
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
            'scope_name' => 'Scope Name',
        ];
    }
}
