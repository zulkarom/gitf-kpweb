<?php

namespace backend\modules\erpd\models;

use Yii;

/**
 * This is the model class for table "rp_knowledge_transfer_member".
 *
 * @property int $id
 * @property int $ktp_id
 * @property int $staff_id
 * @property string $ext_name
 */
class KnowledgeTransferMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_knowledge_transfer_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ktp_id', 'staff_id', 'ext_name'], 'required'],
            [['ktp_id', 'staff_id'], 'integer'],
            [['ext_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ktp_id' => 'Ktp ID',
            'staff_id' => 'Staff ID',
            'ext_name' => 'Ext Name',
        ];
    }
}
