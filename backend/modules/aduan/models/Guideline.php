<?php

namespace backend\modules\aduan\models;

use Yii;

/**
 * This is the model class for table "adu_guideline".
 *
 * @property int $id
 * @property string $guideline_text
 */
class Guideline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adu_guideline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guideline_text'], 'required'],
            [['guideline_text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guideline_text' => 'Guideline Text',
        ];
    }
}
