<?php

namespace backend\modules\erpd\models;

use Yii;

/**
 * This is the model class for table "research_grant".
 *
 * @property int $id
 * @property string $gra_name
 * @property string $gra_abbr
 * @property int $gra_order
 */
class ResearchGrant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_research_grant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gra_name', 'gra_abbr', 'gra_order'], 'required'],
            [['gra_order'], 'integer'],
            [['gra_name'], 'string', 'max' => 200],
            [['gra_abbr'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Gra ID',
            'gra_name' => 'Gra Name',
            'gra_abbr' => 'Gra Abbr',
            'gra_order' => 'Gra Order',
        ];
    }
}
