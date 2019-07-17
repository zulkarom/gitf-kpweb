<?php

namespace backend\modules\erpd\models;

use Yii;

/**
 * This is the model class for table "rp_pub_editor".
 *
 * @property int $edit_id
 * @property int $pub_id
 * @property string $edit_name
 */
class Editor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_pub_editor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			
            [['pub_id'], 'integer'],
            [['edit_name'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'edit_id' => 'Edit ID',
            'pub_id' => 'Pub ID',
            'edit_name' => 'Edit Name',
        ];
    }
}
