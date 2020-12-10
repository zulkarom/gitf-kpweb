<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "urlredirect".
 *
 * @property int $id
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
            [['url_to'], 'string'],
            [['hit_counter', 'latest_hit'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_to' => 'Url To',
            'hit_counter' => 'Hit Counter',
            'latest_hit' => 'Latest Hit',
        ];
    }
}
