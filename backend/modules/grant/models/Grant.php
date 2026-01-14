<?php

namespace backend\modules\grant\models;

use yii\db\ActiveRecord;
use backend\modules\postgrad\models\Supervisor;

class Grant extends ActiveRecord
{
    public static function tableName()
    {
        return 'grn_grant';
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->head_researcher_id) {
            $sv = $this->headResearcher;
            if ($sv) {
                $this->head_researcher_name = (string) $sv->svNamePlain;
            }
        }

        return true;
    }

    public function rules()
    {
        return [
            [['grant_title', 'category_id', 'type_id', 'head_researcher_name', 'amount', 'date_start'], 'required'],
            [['grant_title'], 'string'],
            [['category_id', 'type_id', 'head_researcher_id', 'is_extended'], 'integer'],
            [['amount'], 'number'],
            [['date_start', 'date_end'], 'safe'],
            [['project_code', 'head_researcher_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grant_title' => 'Grant Title',
            'project_code' => 'Project Code',
            'category_id' => 'Category',
            'type_id' => 'Type',
            'head_researcher_id' => 'Head Researcher',
            'head_researcher_name' => 'Head Researcher Name',
            'amount' => 'Amount',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'is_extended' => 'Is Extended',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getType()
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getHeadResearcher()
    {
        return $this->hasOne(Supervisor::class, ['id' => 'head_researcher_id']);
    }
}
