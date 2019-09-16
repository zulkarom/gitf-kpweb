<?php

namespace backend\modules\jeb\models;

use Yii;
use raoul2000\workflow\validation\WorkflowValidator;
use raoul2000\workflow\validation\WorkflowScenario;
use common\models\User;
use backend\modules\jeb\models\EmailTemplate;
use common\models\AuthAssignment;

/**
 * This is the model class for table "jeb_article".
 *
 * @property int $id
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
 * @property string $pre_evaluate_at
 * @property int $pre_evaluate_by
 * @property int $associate_editor
 * @property string $review_file
 * @property string $pre_evaluate_note
 * @property string $asgn_reviewer_at
 * @property int $asgn_reviewer_by
 * @property string $review_at
 * @property int $recommend_by
 * @property string $recommend_at
 * @property string $recommend_note
 * @property int $recommend_option
 * @property int $evaluate_option
 * @property string $evaluate_note
 * @property int $evaluate_by
 * @property string $evaluate_at
 * @property int $response_by
 * @property string $response_at
 * @property string $response_note
 * @property string $correction_at
 * @property string $correction_note
 * @property string $correction_file
 * @property int $post_evaluate_by
 * @property string $post_evaluate_at
 * @property int $assistant_editor
 * @property string $galley_proof_at
 * @property int $galley_proof_by
 * @property string $galley_proof_note
 * @property string $galley_file
 * @property string $finalise_at
 * @property int $finalise_option
 * @property string $finalise_note
 * @property string $finalise_file
 * @property string $asgn_profrdr_at
 * @property int $asgn_profrdr_by
 * @property string $asgn_profrdr_note
 * @property int $proof_reader
 * @property string $post_finalise_at
 * @property int $post_finalise_by
 * @property string $postfinalise_file
 * @property string $post_finalise_note
 * @property string $proofread_at
 * @property int $proofread_by
 * @property string $proofread_note
 * @property string $proofread_file
 * @property string $camera_ready_at
 * @property int $camera_ready_by
 * @property string $camera_ready_note
 * @property string $cameraready_file
 * @property string $journal_at
 * @property int $journal_by
 * @property int $journal_id
 * @property string $reject_at
 * @property int $reject_by
 * @property string $reject_note
 */
class Article extends \yii\db\ActiveRecord
{
	
	public $submission_instance;
	public $review_instance;
	public $correction_instance;
	public $galley_instance;
	public $finalise_instance;
	public $proofread_instance;
	public $cameraready_instance;
	public $postfinalise_instance;
	public $email_workflow;
	
	public $file_controller;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeb_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['status'], WorkflowValidator::className()],
			
            [['title', 'keyword', 'abstract', 'scope_id', 'user_id'], 'required', 'on' => WorkflowScenario::enterStatus('aa-draft')],
			
			[['manuscript_no'], 'required', 'on' => 'manuscript'],
			
			['manuscript_no', 'unique', 'targetClass' => '\backend\modules\jeb\models\Article', 'message' => 'This manuscript no. has already been taken'],
			
			[['submit_at', 'submission_file'], 'required', 'on' => WorkflowScenario::enterStatus('ba-pre-evaluate')],
			
			[['pre_evaluate_at', 'associate_editor', 'pre_evaluate_by', 'review_file'], 'required', 'on' => WorkflowScenario::enterStatus('ca-assign-reviewer')],
			
			[['asgn_reviewer_by', 'asgn_reviewer_at'], 'required', 'on' => WorkflowScenario::enterStatus('da-review')],
			
			[['review_at'], 'required', 'on' => WorkflowScenario::enterStatus('ea-recommend')],
			
			[['recommend_at', 'recommend_by', 'recommend_note', 'recommend_option'], 'required', 'on' => WorkflowScenario::enterStatus('fa-evaluate')],
			
			[['evaluate_at', 'evaluate_by', 'evaluate_note', 'evaluate_option'], 'required', 'on' => WorkflowScenario::enterStatus('ga-response')],
			
			[['response_at', 'response_by', 'response_note'], 'required', 'on' => WorkflowScenario::enterStatus('ha-correction')],
			
			[['correction_at', 'correction_note', 'correction_file', 'title', 'abstract', 'keyword'], 'required', 'on' => WorkflowScenario::enterStatus('ia-post-evaluate')],
			
			[['post_evaluate_at', 'post_evaluate_by', 'assistant_editor'], 'required', 'on' => WorkflowScenario::enterStatus('ja-galley-proof')],
			
			[['asgn_profrdr_at', 'asgn_profrdr_by', 'galley_file'], 'required', 'on' => WorkflowScenario::enterStatus('ka-assign-proof-reader')],
			
			[['proof_reader'], 'required', 'on' => WorkflowScenario::enterStatus('la-proofread')],
			
			[['proofread_file', 'finalise_at'], 'required', 'on' => WorkflowScenario::enterStatus('ma-finalise')],
			
			[['finalise_file'], 'required', 'when' => function($model){
				return $model->finalise_option == 2;
			}],
			
			[['proofread_by', 'proofread_at'], 'required', 'on' => WorkflowScenario::enterStatus('oa-camera-ready')],
			
			[['cameraready_file', 'camera_ready_at', 'camera_ready_by'], 'required', 'on' => WorkflowScenario::enterStatus('pa-assign-journal')],
			
			[['journal_id'], 'required', 'on' => WorkflowScenario::enterStatus('qa-publish')],
			
			[['reject_at', 'reject_by', 'reject_note'], 'required', 'on' => WorkflowScenario::enterStatus('ra-reject')],
			
			[['withdraw_request_at', 'withdraw_note'], 'required', 'on' => WorkflowScenario::enterStatus('sa-withdraw-request')],
			
			[['withdraw_at', 'withdraw_by'], 'required', 'on' => WorkflowScenario::enterStatus('ta-withdraw')],
			
			[['publish_number'], 'required', 'on' => 'publish_number'],
			
            [['title', 'title_sc', 'keyword', 'abstract', 'reference', 'pre_evaluate_note', 'recommend_note', 'response_note', 'correction_note', 'correction_file', 'galley_proof_note', 'galley_file', 'finalise_note', 'finalise_file', 'asgn_profrdr_note', 'proofread_note', 'proofread_file', 'postfinalise_file', 'post_finalise_note', 'cameraready_file', 'reject_note', 'publish_number', 'camera_ready_note', 'withdraw_note', 'doi_ref'], 'string'],
			
            [['journal_id', 'pre_evaluate_by', 'asgn_reviewer_by', 'evaluate_by', 'post_evaluate_by', 'galley_proof_by', 'asgn_profrdr_by', 'post_finalise_by', 'proofread_by', 'camera_ready_by', 'journal_by', 'scope_id', 'associate_editor', 'recommend_by', 'recommend_option', 'response_by', 'assistant_editor', 'finalise_option', 'proof_reader', 'withdraw_by', 'page_from', 'page_to'], 'integer'],
			
            [['draft_at', 'pre_evaluate_at', 'asgn_reviewer_at', 'evaluate_at', 'correction_at', 'post_evaluate_at', 'galley_proof_at', 'finalise_at', 'asgn_profrdr_at', 'post_finalise_at', 'proofread_at', 'camera_ready_at', 'journal_at', 'updated_at', 'review_at', 'recommend_at', 'response_at', 'withdraw_at', 'withdraw_request_at', 'submit_at', 'finalised_at'], 'safe'],
			
            [['status'], 'string', 'max' => 100],
			
			[['correction_file', 'galley_file', 'submission_file', 'finalise_file', 'proofread_file', 'postfinalise_file', 'cameraready_file'], 'string', 'max' => 200],
			
			//upload///
			
			[['submission_file'], 'required', 'on' => 'submission_upload'],
			[['submission_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx', 'maxSize' => 5000000],
			[['updated_at'], 'required', 'on' => 'submission_delete'],
			
			[['review_file'], 'required', 'on' => 'review_upload'],
			[['review_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
			[['updated_at'], 'required', 'on' => 'review_delete'],
			
			[['correction_file'], 'required', 'on' => 'correction_upload'],
			[['correction_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx', 'maxSize' => 5000000],
			[['updated_at'], 'required', 'on' => 'correction_delete'],
			
			[['galley_file'], 'required', 'on' => 'galley_upload'],
			[['galley_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx', 'maxSize' => 5000000],
			[['updated_at'], 'required', 'on' => 'galley_delete'],
			
			[['finalise_file'], 'required', 'on' => 'finalise_upload'],
			[['finalise_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx', 'maxSize' => 5000000],
			[['updated_at'], 'required', 'on' => 'finalise_delete'],
			
			[['proofread_file'], 'required', 'on' => 'proofread_upload'],
			[['proofread_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx', 'maxSize' => 5000000],
			[['updated_at'], 'required', 'on' => 'proofread_delete'],
			
			[['postfinalise_file'], 'required', 'on' => 'postfinalise_upload'],
			[['postfinalise_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx', 'maxSize' => 5000000],
			[['updated_at'], 'required', 'on' => 'postfinalise_delete'],
			
			[['cameraready_file'], 'required', 'on' => 'cameraready_upload'],
			[['cameraready_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
			[['updated_at'], 'required', 'on' => 'cameraready_delete'],
			
        ];
    }
	
	public function behaviors()
    {
    	return [
			\raoul2000\workflow\base\SimpleWorkflowBehavior::className()
    	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
			'title_sc' => 'Title (sentence case)',
            'keyword' => 'Keyword',
            'abstract' => 'Abstract',
            'reference' => 'Reference',
			'scope_id' => 'Scope',
            'status' => 'Status',
            'journal_id' => 'Journal ID',
            'draft_at' => 'Draft At',
            'pre_evaluate_at' => 'Pre Evaluate At',
            'pre_evaluate_by' => 'Pre Evaluate By',
            'asgn_reviewer_at' => 'Asgn Reviewer At',
            'asgn_reviewer_by' => 'Asgn Reviewer By',
            'evaluate_by' => 'Evaluate By',
            'evaluate_at' => 'Evaluate At',
            'correction_at' => 'Correction At',
            'galley_proof_at' => 'Galley Proof At',
            'galley_proof_by' => 'Galley Proof By',
            'finalise_at' => 'Finalise At',
            'finalised_at' => 'Finalised At',
            'asgn_profrdr_at' => 'Assign Proofreader At',
            'asgn_profrdr_by' => 'Assign Proofreader By',
            'post_finalise_at' => 'Galley Revise At',
            'post_finalise_by' => 'Galley Revise By',
            'proofread_at' => 'Proofread At',
            'proofread_by' => 'Proofread By',
            'camera_ready_at' => 'Camera Ready At',
            'camera_ready_by' => 'Camera Ready By',
            'journal_at' => 'Journal At',
            'journal_by' => 'Journal By',
			'recommend_note' => 'Recommendation Note',
			'galley_file' => 'Galley Proof File',
			'finalise_option' => 'Please choose one',
			'asgn_profrdr_note' => 'Proofread Assignment Note',
			'postfinalise_file' => 'Post Finalise File',
			'cameraready_file' => 'Camera Ready PDF File',
			'doi_ref' => 'DOI'
        ];
    }
	
	public function checkFinaliseFile()
    {
        // no real check at the moment to be sure that the error is triggered
		if($this->finalise_option == 2 and empty($this->finalise_file)){
			$this->addError('finalise_file', 'Please upload modified manuscript if you choose with modification.');
			return false;
		}
        return true;
    }
	
	public function getArticleAuthors()
    {
        return $this->hasMany(ArticleAuthor::className(), ['article_id' => 'id']);
    }
	
	public function getArticleReviewers()
    {
        return $this->hasMany(ArticleReviewer::className(), ['article_id' => 'id']);
    }
	
	
	public function checkInProgressReviewers(){
		$list = $this->articleReviewers;
		if($list){
			foreach($list as $row){
				$status = $row->status;
				if($status == 0 or $status == 10){
					return true;
				}
			}
		}
		return false;
	}
	
	public function getCompletedReviewers()
    {
        return $this->hasMany(ArticleReviewer::className(), ['article_id' => 'id'])->where(['status' => 20]);
    }
	
	public function getAssignedReviewers()
    {
        return $this->hasMany(ArticleReviewer::className(), ['article_id' => 'id'])->where(['status' => 0]);
    }
	
	public function reviewCompleted(){
		
		$result = ArticleReviewer::find()
		->where(['article_id'=> $this->id, 'status' => 0])
		->all();
		
		if($result){
			return false;
		}else{
			return true;
		}
	}
	
	public function getMyReview()
    {
        return ArticleReviewer::findOne(['article_id' => $this->id, 'user_id' => Yii::$app->user->identity->id, 'status' => [0, 10, 20, 30]]);
    }
	
	public function getMyAppointedReview()
    {
        return ArticleReviewer::findOne(['article_id' => $this->id, 'user_id' => Yii::$app->user->identity->id, 'status' => 10]);
    }
	
	public function getMyCompletedReview()
    {
        return ArticleReviewer::findOne(['article_id' => $this->id, 'user_id' => Yii::$app->user->identity->id, 'status' => 20]);
    }
	
	public function getWfStatus(){
		$status = $this->getWorkflowStatus()->getId();
		/* $status = str_replace("ArticleWorkflow/","",$status);
		$status = explode('-', $status);
		$status = $status[1]; */
		return substr($status, 19);
	}
	
	
	public function getWfLabel(){
		$label = $this->getWorkflowStatus()->getLabel();
		$color = $this->getWorkflowStatus()->getMetadata('color');
		$format = '<span class="btn btn-outline-'.$color.' btn-sm">'.strtoupper($label).'</span>';
		return $format;
	}
	
	public function getWfLabelBack(){
		$label = $this->getWorkflowStatus()->getLabel();
		$color = $this->getWorkflowStatus()->getMetadata('color');
		$start_at = $this->getWorkflowStatus()->getMetadata('start_at');
		$format = '<span class="label label-'.$color.'">'.strtoupper($label).'</span>
		<br /><i style="font-size:11px">'.$this->humanTiming($this->$start_at).'</i>
		';
		return $format;
	}
	

	public function getScope(){
		return $this->hasOne(ArticleScope::className(), ['id' => 'scope_id']);
	}
	
	public function getJournal(){
		return $this->hasOne(Journal::className(), ['id' => 'journal_id']);
	}
	
	public function getJournalInfo(){
		$journal = $this->journal;
		
		return $journal->journalName . ', ' . $journal->journal_name;
	}
	
	public function getYear(){
		return date('Y', strtotime($this->journal->published_at));
		
	}
	
	public function getCitation(){
		$authors = $this->stringAuthors();
		$year = ' ('.$this->year.').';
		$title = ' '. ucfirst($this->title_sc) . '.';
		$journal = ' <em>Journal of Entrepreneurship and Business</em>,';
		$vol_is = ' ' . $this->journal->volume . '('.$this->journal->issue .'),';
		$pages = ' ' . $this->page_from . '-' . $this->page_to . '.';
		$doi = ' https://doi.org/' . trim($this->doi_ref);
		
		return $authors.$year.$title.$journal.$vol_is.$pages.$doi;
	}
	
	public function stringAuthors(){
		$authors = $this->articleAuthors;
		$string_au ="";
		if($authors){
		$result_au = $authors;
		$num_au = count($authors);
		
		$i=1;
		foreach($result_au as $row_au){
			$author = $row_au;
			if($i==1){$coma="";
			}else{
				if($i==$num_au){ // last sekali
				$coma=", & ";
				}else{
				$coma=", ";
				}
			}
			$stringau = $this->stringSingleAuthor($row_au);
			$lastname = trim(ucfirst($stringau[0]));
			$stringnotlast = trim(ucfirst($stringau[1]));
			if($stringnotlast==""){
				$string_au .= $coma.$lastname.".";
				
			}else{
				$string_au .= $coma.$lastname.", ".$stringnotlast;
			}
			
		$i++;
		}
		}
	return $string_au;
	}
	
	public function stringSingleAuthor($input){
		//cari ada comma tak
		$lastname = '';
		$stringnotlast = '';
		//$splitcomma = explode(",", $input);
		//$kira = count($splitcomma);
		//if($kira==2){
			
		$lastname = trim($input->lastname);
		//echo $splitcomma[1];
		$split = explode(" ", trim($input->firstname));
		$total2 = count($split);
		//echo $total2;
		$stringnotlast="";
		for($x=1;$x<=$total2;$x++){
			//echo $input.">>".$x."---";
			$notlast = $split[$x-1];
			if($notlast){
				$stringnotlast .= substr($notlast, 0, 1).". ";
			}else{
				$stringnotlast .="";
			}
			
		}
			
		return array($lastname,$stringnotlast);
	}
	
	public function getArticleUrl(){
		$volume = $this->journal->volume; 
		$len = strlen((string)$volume);
		if($len == 1){
			$volume = '0' . $volume;
		}
		$issue = $this->journal->issue;
		$len = strlen((string)$issue);
		if($len == 1){
			$issue = '0' . $issue;
		}
		
		return 'http://jeb.umk.edu.my/JEB.'.$volume . $issue .'.'. $this->publish_number;
	}
	
	
	public function linkArticle(){
		
		$volume = $this->journal->volume; 
		$len = strlen((string)$volume);
		if($len == 1){
			$volume = '0' . $volume;
		}
		$issue = $this->journal->issue;
		$len = strlen((string)$issue);
		if($len == 1){
			$issue = '0' . $issue;
		}
		
		///1002
		
		
		
		return ['site/download', 'volume' => $volume, 'issue' => $issue, 'publish_number' => $this->publish_number];

	}
	
	public function getProofReader(){
		return User::findOne($this->proof_reader);
	}
	
	public function getRecommedBy(){
		return $this->hasOne(User::className(), ['id' => 'recommend_by']);
	}
	
	public function getUser(){
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
	
	public function getAssociateEditor(){
		return $this->hasOne(User::className(), ['id' => 'associate_editor']);
	}
	
	public function getAssignProofreaderBy(){
		return $this->hasOne(User::className(), ['id' => 'asgn_profrdr_by']);
	}
	
	public function getAssistantEditor(){
		return $this->hasOne(User::className(), ['id' => 'assistant_editor']);
	}
	public function getGalleyProofBy(){
		return $this->hasOne(User::className(), ['id' => 'galley_proof_by']);
	}
	
	public function getEvaluateOption(){
		return ReviewForm::reviewOptions()[$this->evaluate_option];
	}
	
	public function getEvaluateBy(){
		return $this->hasOne(User::className(), ['id' => 'evaluate_by']);
	}
	
	public function getRejectBy(){
		return $this->hasOne(User::className(), ['id' => 'reject_by']);
	}
	
	public function getCameraReadyBy(){
		return $this->hasOne(User::className(), ['id' => 'camera_ready_by']);
	}
	public function getResponseBy(){
		return $this->hasOne(User::className(), ['id' => 'response_by']);
	}
	
	public function getPreEvaluateBy(){
		return $this->hasOne(User::className(), ['id' => 'pre_evaluate_by']);
	}
	
	public function getRecommendOption(){
		return ReviewForm::reviewOptions()[$this->recommend_option];
	}
	
	public function getFinaliseOption(){
		switch($this->finalise_option){
			case 1:
			return 'Accept without modification';
			break;
			
			case 2 :
			return 'Accept with modification';
		}
	}
	
	public function getAuthors(){
		$list = $this->articleAuthors;
		$str = '';
		if($list){
			foreach($list as $au){
				$str .= $au->firstname . ' ' . $au->lastname . '<br />';
			}
		}
		return $str;
	}
	
	public function isAssistantEditor(){
		if($this->assistant_editor == Yii::$app->user->identity->id){
			return true;
		}else{
			false;
		}
	}
	
	public function isReviewer(){
		$reviewer = ArticleReviewer::findOne(['user_id' => Yii::$app->user->identity->id, 'article_id' => $this->id]);
		if($reviewer){
			return true;
		}
		return false;
	}
	
	public function isCompletedReviewer(){
		$reviewer = ArticleReviewer::findOne(['user_id' => Yii::$app->user->identity->id, 'article_id' => $this->id, 'status' => 20]);
		if($reviewer){
			return true;
		}
		return false;
	}
	
	public function isAssociateEditor(){
		if($this->associate_editor == Yii::$app->user->identity->id){
			return true;
		}else{
			false;
		}
	}
	
	public function isProofReader(){
		if($this->proof_reader == Yii::$app->user->identity->id){
			return true;
		}else{
			false;
		}
	}
	
	public function getStringAuthors(){
		$ar_authors = $this->articleAuthors;
		$str = '';
		if($ar_authors){
			$i = 1;
			foreach($ar_authors as $au){
				$comma = $i == 1 ? '' : ', ';
				$str .= $comma.$au->firstname . ' ' . $au->lastname;
			$i++;
			}
		}
		
		return $str;
	}
	
	public function authorString($delimiter = false){
		$list = $this->articleAuthors;
		$str = '';
		if($list){
			$total = count($list);
			$sep = $delimiter ? $delimiter : '<br />';
			$i = 1;
			foreach($list as $au){
				$sep = $i == $total ? '' : $sep;
				$str .= $au->firstname . ' ' . $au->lastname . $sep;
			$i++;
			}
		}
		return $str;
	}
	
	public function manuscriptNo(){
		/* if($this->submit_at){
			if($this->submit_at == '0000-00-00 00:00:00' or $this->submit_at == 'NOW()'){
				$time = time();
			}else{
				$time = strtotime($this->submit_at);
			}
		}else{
			$time = time();
		}
		
		$year = date('Y', $time);
		return $year . '.' . $this->id; */
		return $this->manuscript_no;
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
	
	
	public function sendReviewerEmail($user, $template){
		$emails = EmailTemplate::find()->where(['on_enter_workflow' => $template])->all();
		if($emails){
			foreach($emails as $email){
				if($user){
					$this->queueEmail($user, $email);
				}
			}
		}
	}
	
	public function sendEmail($custom = null){
		/* 			Yii::$app->session->addFlash('error', "no email_workflow property value");
			return false; */
			
		if($custom){
			$wf = $custom;
		}else{
			$wf = $this->getWorkflowStatus()->getId();
		}
		
		
		$emails = EmailTemplate::find()->where(['on_enter_workflow' => $wf])->all();

		if($emails){
			foreach($emails as $email){
				$target = json_decode($email->target_role);
				if($target){
					foreach($target as $assignment){
						if($assignment == 'jeb-author'){
							$user = $this->user;
							$this->queueEmail($user, $email);
						}else if($assignment == 'jeb-associate-editor'){
							$user = $this->associateEditor;
							if($user){
								$this->queueEmail($user, $email);
							}
						}else if($assignment == 'jeb-assistant-editor'){
							$user = $this->assistantEditor;
							if($user){
								$this->queueEmail($user, $email);
							}
						}else if($assignment == 'jeb-reviewer'){
							//sending to all reviwers
							$users = $this->assignedReviewers;
							if($users){
								foreach($users as $u){
									$user = User::findOne($u->user_id);
									$this->queueEmail($user, $email);
								}
							}
						}else if($assignment == 'jeb-proof-reader'){
							$user = $this->proofReader;
							if($user){
								$this->queueEmail($user, $email);
							}
						}else if($assignment == 'jeb-managing-editor' or $assignment == 'jeb-editor-in-chief'){
							$users = AuthAssignment::getUsersByAssignment($assignment);
							if($users){
								foreach($users as $u){
									$user = User::findOne($u->user_id);
									$this->queueEmail($user, $email);
								}
							}
						}
					}
				}else{
					Yii::$app->session->addFlash('error', "no_target");
					return false;
				}
			}
			
		}
		
		
		
	}
	
	public function queueEmail($user, $email){
		
		$content = $this->emailContentReplace($email->notification, $user);
		$subject = $email->notification_subject;
		$subject = str_replace('{manuscript-number}', $this->manuscriptNo(), $subject);
		
		return Yii::$app->mailqueue->compose()
		 ->setFrom(['fkp.umk.email@gmail.com' => 'JEB JOURNAL'])
		 ->setReplyTo('jeb.fkp@umk.edu.my')
		 ->setTo([$user->email => $user->fullname])
		 ->setTextBody($content)
		 ->setSubject($subject)
		 ->queue();
	}
	
	public function emailContentReplace($content, $user){
		$manuscript = "Manuscript Number: " . $this->manuscriptNo() . "\n\n" . "Title: " . $this->title . "\n\n" . "Abstract: " . $this->abstract . "\n\n" . "Keywords: " . $this->keyword;
		$manuscriptx = "Title: " . $this->title . "\n\n" . "Abstract: " . $this->abstract . "\n\n" . "Keywords: " . $this->keyword;
		
		$replaces = [
		'{manuscript-information}' => $manuscript,
		'{manuscript-information-x}' => $manuscriptx,
		'{manuscript-number}' => $this->manuscriptNo(),
		'{manuscript-title}' => $this->title,
		'{manuscript-abstract}' => $this->abstract,
		'{manuscript-keywords}' => $this->keyword,
		'{fullname}' => $user->fullname,
		'{email}' => $user->email,
		'{pre-evaluation-note}' =>  $this->pre_evaluate_note,
		'{recommendation-note}' => $this->recommend_note,
		'{recommendation-option}' => $this->recommendOption,
		'{evaluation-note}' => $this->evaluate_note,
		'{evaluation-option}' => $this->evaluateOption,
		'{response-note}' => $this->response_note,
		'{correction-note}' => $this->correction_note,
		'{galley-proof-note}' => $this->galley_proof_note,
		'{finalise-note}' => $this->finalise_note,
		'{finalise-option}' => $this->finaliseOption,
		'{proofread-note}' => $this->proofread_note,
		'{reject-note}' => $this->reject_note,
		'{withdraw-note}' => $this->withdraw_note,
		];
		
		foreach($replaces as $key=>$r){
			$content = str_replace($key, $r, $content);
		}
	
		return $content;
	}
	
	public function humanTiming ($datetime)
	{

		$time = time() - strtotime($datetime); // to get the time since that moment
		$time = ($time<1)? 1 : $time;
		$tokens = array (
			31536000 => 'year',
			//2592000 => 'month',
			//604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'') . ' ago';
		}

	}
	
	

}
