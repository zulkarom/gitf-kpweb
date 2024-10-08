<?php

namespace backend\modules\workshop\models;

use Yii;
use backend\modules\postgrad\models\Kursus;
/**
 * This is the model class for table "kursus_kategori".
 *
 * @property int $id
 * @property string $kategori_name
 * @property string $created_at
 * @property string $updated_at
 */
class KursusKategori extends \yii\db\ActiveRecord
{
    public $kategori;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_kursus_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['kategori'], 'integer'],
            [['kategori_name'], 'string', 'max' => 250],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Kursus Kategori',
            'kategori_name' => 'Category Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getKursus()
    {
        return $this->hasMany(Kursus::className(), ['kategori_id' => 'id']);
    }
    
    public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }

}
