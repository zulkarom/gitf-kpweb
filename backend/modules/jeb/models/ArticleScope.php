<?php

namespace backend\modules\jeb\models;

use Yii;

/**
 * This is the model class for table "article_scope".
 *
 * @property int $id
 * @property string $scope_name
 */
class ArticleScope extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeb_article_scope';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scope_name'], 'required'],
            [['scope_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scope_name' => 'Scope Name',
        ];
    }
}
