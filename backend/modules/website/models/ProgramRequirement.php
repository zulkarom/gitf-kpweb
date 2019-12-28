<?php

namespace backend\modules\website\models;

use Yii;

/**
 * This is the model class for table "web_program_req".
 *
 * @property int $id
 * @property int $program_id
 * @property int $req_type 1=stpm, 2=matric, 3=stam,4=dip
 * @property string $req_text
 * @property string $updated_at
 */
class ProgramRequirement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'web_program_req';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['program_id', 'req_type', 'req_text', 'updated_at'], 'required'],
            [['program_id', 'req_type'], 'integer'],
            [['req_text'], 'string'],
            [['updated_at'], 'safe'],
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
            'req_type' => 'Req Type',
            'req_text' => 'Req Text',
            'updated_at' => 'Updated At',
        ];
    }
}
