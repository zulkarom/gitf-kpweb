<?php

namespace backend\modules\courseFiles\models;

use Yii;

/**
 * This is the model class for table "cf_checklist".
 *
 * @property int $id
 * @property string $level
 * @property string $item
 * @property string $item_bi
 */
class Checklist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cf_checklist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level', 'item', 'item_bi'], 'required'],
            [['level', 'item', 'item_bi'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'item' => 'Item',
            'item_bi' => 'Item Bi',
        ];
    }

    public function getItemPlan(){
        return Checklist::find()
        ->where(['level' => 'Plan'])
        ->all();
    }
    public function getItemDo(){
        return Checklist::find()
        ->where(['level' => 'Do'])
        ->all();
    }
    public function getItemCheck(){
        return Checklist::find()
        ->where(['level' => 'Check'])
        ->all();
    }
    public function getItemAct(){
        return Checklist::find()
        ->where(['level' => 'Act'])
        ->all();
    }

}
