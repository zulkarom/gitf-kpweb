<?php

namespace backend\modules\ecert\models;

use Yii;

/**
 * This is the model class for table "cert_data_com".
 *
 * @property int $id
 * @property string $name
 * @property string $jawatan
 * @property string $matric
 */
class CertDataCom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cert_data_com';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 27],
            [['jawatan'], 'string', 'max' => 38],
            [['matric'], 'string', 'max' => 6],
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
            'jawatan' => 'Jawatan',
            'matric' => 'Matric',
        ];
    }
}
