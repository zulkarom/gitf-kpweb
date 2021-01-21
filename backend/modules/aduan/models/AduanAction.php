<?php

namespace backend\modules\aduan\models;

use Yii;

/**
 * This is the model class for table "adu_aduan_action".
 *
 * @property int $id
 * @property int $aduan_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property string $title
 * @property string $action_text
 */
class AduanAction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adu_aduan_action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action_text'], 'required'],
            [['aduan_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['action_text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aduan_id' => 'Aduan ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'action_text' => 'Write a reply',
        ];
    }
}
