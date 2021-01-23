<?php

namespace backend\modules\aduan\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "adu_setting".
 *
 * @property int $id
 * @property string $penyelia
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adu_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penyelia'], 'required'],
            [['penyelia'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'penyelia' => 'Pegawai Penyelia Aduan',
        ];
    }
	
	public function getUser(){
		return $this->hasOne(User::className(), ['id' => 'penyelia']);
	}
}
