<?php

namespace backend\modules\moderasi\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\staff\models\Staff;

class CourseChecker extends ActiveRecord
{
    public static function tableName()
    {
        return 'mod_course_checker';
    }

    public function rules()
    {
        return [
            [['offered_id', 'updated_at', 'updated_by'], 'required'],
            [['offered_id', 'checker1_staff_id', 'checker2_staff_id', 'updated_by'], 'integer'],
            [['updated_at'], 'safe'],
            [['checker2_staff_id'], 'compare', 'compareAttribute' => 'checker1_staff_id', 'operator' => '!=', 'type' => 'number', 'skipOnEmpty' => true, 'message' => 'Checker/Vetter 2 must be different from Checker/Vetter 1.'],
        ];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->updated_at = new Expression('NOW()');
            $this->updated_by = Yii::$app->user->isGuest ? 0 : (int)Yii::$app->user->id;
        }
        return parent::beforeValidate();
    }

    public function touchUpdated()
    {
        $this->updated_at = new Expression('NOW()');
        $this->updated_by = Yii::$app->user->isGuest ? 0 : (int)Yii::$app->user->id;
    }

    public function getOffered()
    {
        return $this->hasOne(CourseOffered::className(), ['id' => 'offered_id']);
    }

    public function getChecker1()
    {
        return $this->hasOne(Staff::className(), ['id' => 'checker1_staff_id']);
    }

    public function getChecker2()
    {
        return $this->hasOne(Staff::className(), ['id' => 'checker2_staff_id']);
    }

    public static function findByOfferedId($offeredId)
    {
        return self::findOne(['offered_id' => (int)$offeredId]);
    }

    public static function ensureForOfferedId($offeredId)
    {
        $model = self::findByOfferedId($offeredId);
        if ($model) {
            return $model;
        }

        $model = new self();
        $model->offered_id = (int)$offeredId;
        $model->touchUpdated();
        $model->save(false);
        return $model;
    }
}
