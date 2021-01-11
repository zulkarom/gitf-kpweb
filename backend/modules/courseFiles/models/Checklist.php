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
 * @property int $lec_upload
 * @property int $coor_upload
 * @property int $staff_upload
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
            [['level', 'item', 'item_bi', 'lec_upload', 'coor_upload', 'staff_upload'], 'required'],
            [['item', 'item_bi'], 'string'],
            [['lec_upload', 'coor_upload', 'staff_upload'], 'integer'],
            [['level'], 'string', 'max' => 250],
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
            'lec_upload' => 'Lec Upload',
            'coor_upload' => 'Coor Upload',
            'staff_upload' => 'Staff Upload',
        ];
    }
	
	public function getAssessMaterials(){
        return Checklist::find()
        ->where(['category' => 'assess-materials'])
        ->all();
    }
	
	public function getAssessScripts(){
        return Checklist::find()
        ->where(['category' => 'assess-scripts'])
        ->all();
    }
	
	public function getAssessResults(){
        return Checklist::find()
        ->where(['category' => 'assess-results'])
        ->all();
    }
	
	public function getAssessAnalysis(){
        return Checklist::find()
        ->where(['category' => 'assess-analysis'])
        ->all();
    }
	
	public function getCqi(){
        return Checklist::find()
        ->where(['category' => 'cqi'])
        ->all();
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
