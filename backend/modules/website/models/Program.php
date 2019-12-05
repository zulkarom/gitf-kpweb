<?php

namespace backend\modules\website\models;

use Yii;

/**
 * This is the model class for table "web_program".
 *
 * @property int $id
 * @property int $program_id
 * @property string $summary
 * @property string $career
 */
class Program extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'web_program';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'program_id', 'summary', 'career'], 'required'],
            [['id', 'program_id'], 'integer'],
            [['summary', 'career'], 'string'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'program_id' => 'Program ID',
            'summary' => 'Summary',
            'career' => 'Career',
        ];
    }
}
