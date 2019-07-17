<?php

namespace backend\modules\erpd\models;

use Yii;

/**
 * This is the model class for table "pub_author".
 *
 * @property int $au_id
 * @property int $pub_id
 * @property string $au_name
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_pub_author';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['au_name'], 'required'],
			
            [['pub_id'], 'integer'],
            [['au_name'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Au ID',
            'pub_id' => 'Pub ID',
            'au_name' => 'Author Name',
        ];
    }
}
