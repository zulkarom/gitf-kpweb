<?php

namespace backend\modules\sae\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class AnalysisDomain extends Model
{
    /**
     * @var integer
     */

    /**
     * @var array IDs of the favorite foods
     */
    public $grad_ids = [];
    public $batch_id;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
            ['batch_id', 'required'],
            ['batch_id', 'exist', 'targetClass' => Batch::className(), 'targetAttribute' => 'id'],

            ['grad_ids', 'each', 'rule' => [
                'exist', 'targetClass' => GradeCategory::className(), 'targetAttribute' => 'id'
            ]],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'grad_ids' => 'Grade Categories',
        ];
    }

    /**
     * load the user's favorite foods
     */
    public function loadDomains()
    {
        $this->grad_ids = [];
        $domains = Domain::find()->where(['bat_id' => $this->batch_id])->all();

        foreach($domains as $dd) {
            $this->grad_ids[] = $dd->grade_cat;
        }
    }

    /**
     * save the user's favorite foods
     */
    public function saveDomains()
    {
        Domain::deleteAll(['bat_id' => $this->batch_id]);
        if (is_array($this->grad_ids)) {
            foreach($this->grad_ids as $grad_id) {
                $ff = new Domain();
                $ff->bat_id = $this->batch_id;
                $ff->grade_cat = $grad_id;
                $ff->save();
            }
        }
        /* Be careful, $this->food_ids can be empty */
    }
   
    public static function getAvailableDomain()
    {
        $grads = GradeCategory::allDomainsArray();
        $items = ArrayHelper::map($grads, 'id', 'gcat_text');
        return $items;
    }
}

?>