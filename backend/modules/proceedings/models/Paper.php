<?php

namespace backend\modules\proceedings\models;

use Yii;

/**
 * This is the model class for table "proc_paper".
 *
 * @property int $id
 * @property int $proc_id
 * @property string $paper_title
 * @property string $author
 * @property int $paper_no
 * @property string $paper_page
 * @property string $paper_url
 */
class Paper extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proc_paper';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proc_id', 'paper_title', 'author', 'paper_no', 'paper_page', 'paper_url'], 'required'],
            [['proc_id', 'paper_no'], 'integer'],
            [['paper_url'], 'string'],
            [['paper_title', 'author'], 'string', 'max' => 255],
            [['paper_page'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proc_id' => 'Proc ID',
            'paper_title' => 'Paper Title',
            'author' => 'Author',
            'paper_no' => 'Paper No',
            'paper_page' => 'Paper Page',
            'paper_url' => 'Paper Url',
        ];
    }
}
