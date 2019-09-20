<?php

namespace backend\modules\jeb\models;

use Yii;
use common\models\workflows\ArticleWorkflow;

/**
 * This is the model class for table "jeb_article".
 *
 * @property int $id
 * @property int $journal_id
 * @property string $manuscript_no
 * @property int $yearly_number
 * @property int $user_id
 * @property string $title
 * @property string $keyword
 * @property string $abstract
 * @property string $reference
 * @property int $scope_id
 * @property string $status
 * @property string $submission_file
 * @property string $updated_at
 * @property string $draft_at
 * @property string $submit_at
 * @property string $pre_evaluate_at
 * @property int $pre_evaluate_by
 * @property int $invoice_id
 * @property string $payment_file
 * @property string $payment_note
 * @property int $associate_editor
 * @property string $review_file
 * @property string $pre_evaluate_note
 * @property string $asgn_reviewer_at
 * @property string $asgn_associate_at
 * @property int $asgn_reviewer_by
 * @property string $review_at
 * @property string $review_submit_at
 * @property int $response_by
 * @property string $response_at
 * @property string $response_note
 * @property int $response_option
 * @property string $correction_at
 * @property string $correction_note
 * @property string $correction_file
 * @property int $post_evaluate_by
 * @property string $post_evaluate_at
 * @property int $assistant_editor
 * @property string $camera_ready_at
 * @property int $camera_ready_by
 * @property string $camera_ready_note
 * @property string $cameraready_file
 * @property string $assign_journal_at
 * @property string $journal_at
 * @property int $journal_by
 * @property int $journal_issue_id
 * @property string $reject_at
 * @property int $reject_by
 * @property string $reject_note
 * @property string $publish_number
 * @property string $doi_ref
 * @property int $withdraw_by
 * @property string $withdraw_at_status
 * @property string $withdraw_at
 * @property string $withdraw_note
 * @property string $withdraw_request_at
 */
class ArticleOverwrite extends \yii\db\ActiveRecord
{
	public $submission_instance;
	public $review_instance;
	public $correction_instance;
	public $galley_instance;
	public $finalise_instance;
	public $proofread_instance;
	public $cameraready_instance;
	public $postfinalise_instance;
	public $payment_instance;
	public $email_workflow;
	
	public $file_controller;
	
	public $scope_name;
	public $max_yearly;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jeb_article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'title', 'abstract'], 'required'],
			
		
        ];
    }


	
	public function getWfLabel(){
		$status = $this->getWfStatus();
		
		$format = strtoupper($status);
		return $format;
	}
	
	
	public function getWfStatus(){
		$status = $this->status;
		/* $status = str_replace("ArticleWorkflow/","",$status);
		$status = explode('-', $status);
		$status = $status[1]; */
		return substr($status, 19);
	}
	

}
