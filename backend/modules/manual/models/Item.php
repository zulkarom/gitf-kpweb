<?php

namespace backend\modules\manual\models;

use Yii;

/**
 * This is the model class for table "mnl_item".
 *
 * @property int $id
 * @property int $title_id
 * @property string $item_text
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mnl_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_id', 'item_text'], 'required'],
            [['title_id'], 'integer'],
            [['item_text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_id' => 'Title ID',
            'item_text' => 'Item Text',
        ];
    }
}
