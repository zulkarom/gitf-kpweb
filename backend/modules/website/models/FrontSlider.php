<?php

namespace backend\modules\website\models;

use Yii;
use common\models\User;
use oonne\sortablegrid\SortableGridBehavior;

/**
 * This is the model class for table "web_front_slider".
 *
 * @property int $id
 * @property string $image_file
 * @property string $caption
 */
class FrontSlider extends \yii\db\ActiveRecord
{
	public $image_instance;
	public $file_controller;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_front_slider';
    }
	
	public function behaviors()
{
    return [
        'sort' => [
            'class' => SortableGridBehavior::className(),
            'sortableAttribute' => 'slide_order'
        ],
    ];
}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slide_name', 'is_publish'], 'required', 'on' => 'create'],
			[['image_file', 'slide_name', 'slide_order'], 'required', 'on' => 'update'],
            [['image_file', 'caption', 'slide_url'], 'string'],
			
			[['slide_order', 'is_publish'], 'integer'],
			[['updated_at'], 'safe'],
			
			[['image_file'], 'required', 'on' => 'image_upload'],
            [['image_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png', 'maxSize' => 1000000],
            [['updated_at'], 'required', 'on' => 'image_delete'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_file' => 'Slide File',
			 'is_publish' => 'Publish',
			  'slide_order' => 'Order',
            'caption' => 'Caption',
        ];
    }
	
	public function getCreatedBy(){
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
	

}
