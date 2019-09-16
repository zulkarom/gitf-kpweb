<?php

namespace backend\modules\jeb\models;

use Yii;

/**
 * This is the model class for table "article_author".
 *
 * @property int $id
 * @property int $article_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 */
class ArticleAuthor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeb_article_author';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'email'], 'required'],
			
            [['article_id'], 'integer'],
			
			[['email'], 'email'],
			
            [['firstname', 'lastname'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
        ];
    }
	
	
}
