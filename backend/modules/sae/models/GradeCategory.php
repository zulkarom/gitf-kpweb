<?php

namespace backend\modules\sae\models;

use Yii;

/**
 * This is the model class for table "psy_grade_cat".
 *
 * @property int $id
 * @property string $gcat_text
 * @property int $gcat_order
 */
class GradeCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'psy_grade_cat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gcat_text', 'gcat_order'], 'required'],
            [['gcat_order'], 'integer'],
            [['gcat_text'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gcat_text' => 'Gcat Text',
            'gcat_order' => 'Gcat Order',
        ];
    }

    public static function getGradeCat()
    {
        $query = self::find()
        // ->select('id', 'gcat_text')
        ->orderBy('gcat_order ASC')
        ->all();
        return $query;
    }

    public static function getTotalByCat($user_id, $grow_id)
    {
        $result_cat = Answer::getAnswersByCat($user_id,$grow_id);
        $jum = 0;
        foreach($result_cat as $rowcat){
            if($rowcat->answer == 1){
                $jum +=1;
            }
        }
        return $jum;
    }
	
	public static function allDomains(){
		return self::find()
		->where(['is_total' => 0])
		->orderBy('gcat_order ASC')
		->all();
	}
	
	public static function allDomainsWithTotal(){
		return self::find()
		->orderBy('gcat_order ASC')
		->all();
	}
	
	public static function allDomainsArray(){
		return self::find()
		->where(['is_total' => 0])
		->orderBy('gcat_order ASC')
		->asArray()
		->all();
	}
}
