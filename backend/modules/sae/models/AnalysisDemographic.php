<?php

namespace backend\modules\sae\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class AnalysisDemographic extends Model
{
    /**
     * @var integer
     */

    /**
     * @var array IDs of the favorite foods
     */
    public $col_ids = [];
    public $col2_ids = [];
    public $col3_ids = [];
    public $col4_ids = [];
    public $batch_id;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
            ['batch_id', 'required'],
            ['batch_id', 'exist', 'targetClass' => Batch::className(), 'targetAttribute' => 'id'],

            ['col_ids', 'each', 'rule' => [
                'exist', 'targetClass' => Answer::className(), 'targetAttribute' => 'column1'
            ]],

            ['col2_ids', 'each', 'rule' => [
                'exist', 'targetClass' => Answer::className(), 'targetAttribute' => 'column2'
            ]],

            ['col3_ids', 'each', 'rule' => [
                'exist', 'targetClass' => Answer::className(), 'targetAttribute' => 'column3'
            ]],

            ['col4_ids', 'each', 'rule' => [
                'exist', 'targetClass' => Answer::className(), 'targetAttribute' => 'column4'
            ]],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'col_ids' => 'Column 1',
        ];
    }

    /**
     * load the user's favorite foods
     */
    public function loadColumn1()
    {
        $this->col_ids = [];
        $demos = Demographic::find()->where(['bat_id' => $this->batch_id, 'column_id' => 1])->all();

        foreach($demos as $dd) {
            $this->col_ids[] = $dd->demo_value;
        }
    }

    public function loadColumn2()
    {
        $this->col2_ids = [];
        $demos = Demographic::find()->where(['bat_id' => $this->batch_id, 'column_id' => 2])->all();

        foreach($demos as $dd) {
            $this->col2_ids[] = $dd->demo_value;
        }
    }

    public function loadColumn3()
    {
        $this->col3_ids = [];
        $demos = Demographic::find()->where(['bat_id' => $this->batch_id, 'column_id' => 3])->all();

        foreach($demos as $dd) {
            $this->col3_ids[] = $dd->demo_value;
        }
    }

    public function loadColumn4()
    {
        $this->col4_ids = [];
        $demos = Demographic::find()->where(['bat_id' => $this->batch_id, 'column_id' => 4])->all();

        foreach($demos as $dd) {
            $this->col4_ids[] = $dd->demo_value;
        }
    }

    // /**
    //  * save the user's favorite foods
    //  */
    public function saveColumn1()
    {
        Demographic::deleteAll(['bat_id' => $this->batch_id, 'column_id' => 1]);
        if (is_array($this->col_ids)) {
            foreach($this->col_ids as $col_name) {
                $ff = new Demographic();
                $ff->bat_id = $this->batch_id;
                $ff->column_id = 1;
                $ff->demo_value = $col_name;
                $ff->save();
            }
        }
        /* Be careful, $this->food_ids can be empty */
    }

    public function saveColumn2()
    {
        Demographic::deleteAll(['bat_id' => $this->batch_id, 'column_id' => 2]);
        if (is_array($this->col2_ids)) {
            foreach($this->col2_ids as $col_name) {
                $ff = new Demographic();
                $ff->bat_id = $this->batch_id;
                $ff->column_id = 2;
                $ff->demo_value = $col_name;
                $ff->save();
            }
        }
        /* Be careful, $this->food_ids can be empty */
    }

    public function saveColumn3()
    {
        Demographic::deleteAll(['bat_id' => $this->batch_id, 'column_id' => 3]);
        if (is_array($this->col3_ids)) {
            foreach($this->col3_ids as $col_name) {
                $ff = new Demographic();
                $ff->bat_id = $this->batch_id;
                $ff->column_id = 3;
                $ff->demo_value = $col_name;
                $ff->save();
            }
        }
        /* Be careful, $this->food_ids can be empty */
    }
    
    public function saveColumn4()
    {
        Demographic::deleteAll(['bat_id' => $this->batch_id, 'column_id' => 4]);
        if (is_array($this->col4_ids)) {
            foreach($this->col4_ids as $col_name) {
                $ff = new Demographic();
                $ff->bat_id = $this->batch_id;
                $ff->column_id = 4;
                $ff->demo_value = $col_name;
                $ff->save();
            }
        }
        /* Be careful, $this->food_ids can be empty */
    }

    /**
     * @return array available foods
     */
    public static function getAvailableColumn1($bat_id)
    {
        $columns = Answer::find()
        ->select('DISTINCT(column1)')
        ->where(['bat_id' => $bat_id])
        ->all();
        $items = ArrayHelper::map($columns, 'column1', 'column1');
        return $items;
    }

    public static function getAvailableColumn2($bat_id)
    {
        $columns = Answer::find()
        ->select('DISTINCT(column2)')
        ->where(['bat_id' => $bat_id])
        ->all();
        $items = ArrayHelper::map($columns, 'column2', 'column2');
        return $items;
    }

    public static function getAvailableColumn3($bat_id)
    {
        $columns = Answer::find()
        ->select('DISTINCT(column3)')
        ->where(['bat_id' => $bat_id])
        ->all();
        $items = ArrayHelper::map($columns, 'column3', 'column3');
        return $items;
    }

    public static function getAvailableColumn4($bat_id)
    {
        $columns = Answer::find()
        ->select('DISTINCT(column4)')
        ->where(['bat_id' => $bat_id])
        ->all();
        $items = ArrayHelper::map($columns, 'column4', 'column4');
        return $items;
    }

}

?>