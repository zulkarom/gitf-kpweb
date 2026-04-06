<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "urlredirect".
 *
 * @property int $id
 * @property string $code
 * @property string $url_to
 * @property int $hit_counter
 * @property int $latest_hit
 */
class Urlredirect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'urlredirect';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'url_to'], 'required'],
            [['code'], 'string', 'max' => 16],
            [['code'], 'string', 'min' => 2],
            [['code'], 'unique'],
            [['url_to'], 'string'],
            [['hit_counter'], 'default', 'value' => 0],
            [['hit_counter'], 'integer'],
            [['latest_hit'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'url_to' => 'Url To',
            'hit_counter' => 'Hit Counter',
            'latest_hit' => 'Latest Hit',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            if ($this->hit_counter === null) {
                $this->hit_counter = 0;
            }
        }

        return parent::beforeSave($insert);
    }
}
