<?php

namespace backend\modules\aduan\models;

use Yii;

/**
 * This is the model class for table "adu_aduan_progress".
 *
 * @property int $id
 * @property string $progress
 */
class AduanProgress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adu_aduan_progress';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['progress'], 'required'],
            [['progress'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'progress' => 'Progress',
        ];
    }
}
