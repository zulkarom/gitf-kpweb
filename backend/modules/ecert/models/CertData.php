<?php

namespace backend\modules\ecert\models;

use Yii;

/**
 * This is the model class for table "cert_data".
 *
 * @property int $id
 * @property string $name
 * @property string $identifier
 */
class CertData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cert_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
            [['identifier'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'identifier' => 'Identifier',
        ];
    }
}
