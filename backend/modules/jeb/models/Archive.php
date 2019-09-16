<?php

namespace backend\modules\jeb\models;

use Yii;

/**
 * This is the model class for table "archive".
 *
 * @property int $id
 * @property string $author
 * @property string $title
 * @property string $abstract
 * @property string $reference
 * @property string $pdf_file
 * @property string $keywords
 * @property int $volume
 * @property int $issue
 * @property string $priod
 */
class Archive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'archive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author', 'abstract', 'reference'], 'string'],
            [['volume', 'issue'], 'integer'],
            [['title', 'keywords'], 'string', 'max' => 200],
            [['pdf_file'], 'string', 'max' => 6],
            [['priod'], 'string', 'max' => 13],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'title' => 'Title',
            'abstract' => 'Abstract',
            'reference' => 'Reference',
            'pdf_file' => 'Pdf File',
            'keywords' => 'Keywords',
            'volume' => 'Volume',
            'issue' => 'Issue',
            'priod' => 'Priod',
        ];
    }
}
