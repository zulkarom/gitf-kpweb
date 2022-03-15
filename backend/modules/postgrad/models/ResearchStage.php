<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_res_stage".
 *
 * @property int $id
 * @property string $stage_name
 */
class ResearchStage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_res_stage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stage_name', 'stage_abbr'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stage_name' => 'Stage Name',
        ];
    }
}
