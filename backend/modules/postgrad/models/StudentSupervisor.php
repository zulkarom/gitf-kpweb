<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_student_sv".
 *
 * @property int $id
 * @property int $supervisor_id
 * @property string $appoint_at
 */
class StudentSupervisor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_student_sv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supervisor_id'], 'required'],
            [['supervisor_id'], 'integer'],
            [['appoint_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supervisor_id' => 'Supervisor ID',
            'appoint_at' => 'Appoint At',
        ];
    }
}
