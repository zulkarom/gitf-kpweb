<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_author".
 *
 * @property int $id
 * @property int $paper_id
 * @property string $fullname
 * @property int $author_order
 *
 * @property ConfPaper $paper
 */
class ConfAuthor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname'], 'required'],
			
            [['paper_id', 'author_order'], 'integer'],
			
            [['fullname'], 'string', 'max' => 200],
			
            [['paper_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfPaper::className(), 'targetAttribute' => ['paper_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paper_id' => 'Paper ID',
            'fullname' => 'Fullname',
            'author_order' => 'Author Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaper()
    {
        return $this->hasOne(ConfPaper::className(), ['id' => 'paper_id']);
    }
}
