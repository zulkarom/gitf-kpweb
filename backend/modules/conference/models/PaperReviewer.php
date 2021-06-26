<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_paper_reviewer".
 *
 * @property int $id
 * @property int $paper_id
 * @property int $scope_id
 * @property int $user_id
 * @property int $status 0 => 'Appoint', 10 => 'Review In Progress', 20 => 'Completed', 30 => 'Reject', 40 => 'Canceled', 50 => 'Error'
 * @property int $q_1
 * @property int $q_2
 * @property int $q_3
 * @property int $q_4
 * @property int $q_5
 * @property int $q_6
 * @property int $q_7
 * @property int $q_8
 * @property int $q_9
 * @property int $q_10
 * @property int $q_11
 * @property string $q_1_note
 * @property string $q_2_note
 * @property string $q_3_note
 * @property string $q_4_note
 * @property string $q_5_note
 * @property string $q_6_note
 * @property string $q_7_note
 * @property string $q_8_note
 * @property string $q_9_note
 * @property string $q_10_note
 * @property string $q_11_note
 * @property int $review_option
 * @property string $review_note
 * @property string $reviewed_file
 * @property string $review_at
 * @property string $created_at
 * @property string $completed_at
 * @property string $cancel_at
 * @property string $reject_at
 */
class PaperReviewer extends \yii\db\ActiveRecord
{
	public $reviewed_instance;
	public $reject_note;
	public $file_controller;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_paper_reviewer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paper_id', 'user_id'], 'required', 'on' => 'create'],
            
            [['q_1_note', 'q_2_note', 'q_3_note', 'q_4_note', 'q_5_note', 'q_6_note', 'q_7_note', 'review_option'], 'required', 'on' => 'review'],
			
			
            [['paper_id', 'scope_id', 'user_id', 'status', 'q_1', 'q_2', 'q_3', 'q_4', 'q_5', 'q_6', 'q_7', 'q_8', 'q_9', 'q_10', 'q_11', 'review_option'], 'integer'],
            [['q_1_note', 'q_2_note', 'q_3_note', 'q_4_note', 'q_5_note', 'q_6_note', 'q_7_note', 'q_8_note', 'q_9_note', 'q_10_note', 'q_11_note', 'review_note', 'reject_note'], 'string'],
            [['review_at', 'created_at', 'completed_at', 'cancel_at', 'reject_at'], 'safe'],
            
			[['reviewed_file'], 'string', 'max' => 200],
            
			
			/////
			[['reviewed_file'], 'required', 'on' => 'reviewed_upload'],
            [['reviewed_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx, pdf', 'maxSize' => 5000000],
			
            [['updated_at'], 'required', 'on' => 'reviewed_delete'],
            
            ['reject_note', 'required', 'when' => function($model){
                return $model->review_option == '1';},
                'whenClient' => "function (attribute, value) {
        return $('#review_option').val() == '1';
                         }",
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paper_id' => 'Paper ID',
            'scope_id' => 'Scope ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'q_1' => 'Q 1',
            'q_2' => 'Q 2',
            'q_3' => 'Q 3',
            'q_4' => 'Q 4',
            'q_5' => 'Q 5',
            'q_6' => 'Q 6',
            'q_7' => 'Q 7',
            'q_8' => 'Q 8',
            'q_9' => 'Q 9',
            'q_10' => 'Q 10',
            'q_11' => 'Q 11',
            'q_1_note' => 'Q 1 Note',
            'q_2_note' => 'Q 2 Note',
            'q_3_note' => 'Q 3 Note',
            'q_4_note' => 'Q 4 Note',
            'q_5_note' => 'Q 5 Note',
            'q_6_note' => 'Q 6 Note',
            'q_7_note' => 'Q 7 Note',
            'q_8_note' => 'Q 8 Note',
            'q_9_note' => 'Q 9 Note',
            'q_10_note' => 'Q 10 Note',
            'q_11_note' => 'Q 11 Note',
            'review_option' => 'Review Option',
            'review_note' => 'Review Note',
            'reviewed_file' => 'Reviewed File',
            'review_at' => 'Review At',
            'created_at' => 'Created At',
            'completed_at' => 'Completed At',
            'cancel_at' => 'Cancel At',
            'reject_at' => 'Reject At',
        ];
    }
	
	public function getPaper()
    {
        return $this->hasOne(ConfPaper::className(), ['id' => 'paper_id']);
    }
}
