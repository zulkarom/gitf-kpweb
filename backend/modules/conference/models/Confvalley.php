<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "confvalley".
 *
 * @property int $id
 * @property string $address
 * @property string $phone1
 * @property string $phone2
 * @property string $about
 * @property string $email_to
 */
class Confvalley extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'confvalley';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'phone1', 'phone2', 'about', 'email_to'], 'required'],
            [['about'], 'string'],
            [['address', 'email_to'], 'string', 'max' => 200],
            [['phone1', 'phone2'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'phone1' => 'Phone1',
            'phone2' => 'Phone2',
            'about' => 'About',
            'email_to' => 'Email To',
        ];
    }
}
