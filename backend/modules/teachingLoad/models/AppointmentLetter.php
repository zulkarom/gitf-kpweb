<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\teachingLoad\models\StaffInvolved;
use backend\modules\teachingLoad\models\CourseOffered;
/**
 * This is the model class for table "tld_appoint_letter".
 *
 * @property int $id
 * @property int $inv_id
 * @property int $offered_id
 * @property string $ref_no
 * @property string $date_appoint
 */
class AppointmentLetter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_appoint_letter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inv_id', 'offered_id'], 'required'],
            [['inv_id', 'offered_id'], 'integer'],
            [['date_appoint'], 'safe'],
            [['ref_no'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inv_id' => 'Inv ID',
            'offered_id' => 'Offered ID',
            'ref_no' => 'Ref No',
            'date_appoint' => 'Date Appoint',
        ];
    }

    public function getStaffInvolved(){
        return $this->hasOne(StaffInvolved::className(), ['id' => 'inv_id']);
    }

    public function getCourseOffered(){
        return $this->hasOne(CourseOffered::className(), ['id' => 'offered_id']);
    }
}
