<?php

namespace backend\modules\jeb\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "jeb_article_reviewer".
 *
 * @property int $id
 * @property int $article_id
 * @property int $scope_id
 * @property int $user_id
 * @property int $status
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
 * @property int $review_option
 * @property string $review_note
 * @property string $reviewed_file
 */
class ArticleReviewer extends \yii\db\ActiveRecord
{
	public $reviewed_instance;
	
	public $inex = 0;
	
	public $file_controller;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeb_article_reviewer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scope_id', 'user_id'], 'required', 'on' => 'assign'],
			
			[['status', 'q_1', 'q_2', 'q_3', 'q_4', 'q_5', 'q_6', 'q_7', 'q_8', 'q_9', 'q_10', 'q_11', 'review_option', 'review_note'], 'required', 'on' => 'review'],
			
			[['status'], 'required', 'on' => 'accept'],
			
			[['status', 'cancel_at'], 'required', 'on' => 'cancel'],
			
            [['status', 'q_1', 'q_2', 'q_3', 'q_4', 'q_5', 'q_6', 'q_7', 'q_8', 'q_9', 'q_10', 'q_11', 'review_option'], 'integer'],
			
            [['review_note'], 'string'],
			
			[['scope_id', 'user_id'], 'integer'],
			
            [['reviewed_file'], 'string', 'max' => 200],
			
			/////
			[['reviewed_file'], 'required', 'on' => 'reviewed_upload'],
            [['reviewed_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx, pdf', 'maxSize' => 5000000],
			
            [['review_at'], 'required', 'on' => 'reviewed_delete'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
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
            'review_option' => 'Review Option',
            'review_note' => 'Review Note',
            'reviewed_file' => 'Reviewed File',
        ];
    }
	
	public function listReviewers(){
		$this->setInex();
		return  UserScope::listReviewers($this->scope_id, $this->inex);

	}
	
	public function setInex(){
			$staff =  self::find()
			->innerJoin('auth_assignment', 'auth_assignment.user_id = jeb_article_reviewer.user_id' )
			->innerJoin('staff', 'staff.user_id = jeb_article_reviewer.user_id' )
			->where(['jeb_article_reviewer.user_id' => $this->user_id, 'auth_assignment.item_name' => 'jeb-reviewer'])
			->all();
			
			$associate =  self::find()
			->innerJoin('auth_assignment', 'auth_assignment.user_id = jeb_article_reviewer.user_id' )
			->innerJoin('jeb_associate', 'jeb_associate.user_id = jeb_article_reviewer.user_id' )
			->where(['jeb_article_reviewer.user_id' => $this->user_id, 'auth_assignment.item_name' => 'jeb-reviewer'])
			->all();
			if($staff){
				$this->inex = 1;
			}else if($associate){
				$this->inex = 2;
			}
	}
	
	public function getInternalExternal(){
		$this->setInex();
		return $this->inex;
	}
	
	public function getInternalExternalText(){
		$inex = $this->getInternalExternal();
		if($inex == 1){
			return 'Internal';
		}else if($inex == 2){
			return 'External';
		}else{
			return '';
		}
	}
	
	public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	
	public function getScope(){
        return $this->hasOne(ArticleScope::className(), ['id' => 'scope_id']);
    }
	
	public function getStatusText(){
		$arr = [0,10,20,30,40];
		if(!in_array($this->status,$arr)){
			$status = 50;
		}else{
			$status = $this->status;
		}
		$arr_str = [0 => 'Appoint', 10 => 'Review In Progress', 20 => 'Completed', 30 => 'Reject', 40 => 'Canceled', 50 => 'Error' ];
		return $arr_str[$status];
	}
	
	public function getStatusLabel($front = false){
		$arr = [0,10,20,30,40];
		if(!in_array($this->status,$arr)){
			$status = 50;
		}else{
			$status = $this->status;
		}
		$color = [0 => 'info', 10 => 'warning', 20 => 'success', 30 => 'danger', 40 => 'danger', 50 => 'danger' ];
		if($front){
			return '<span class="btn btn-outline-'.$color[$status].' btn-sm">'. strtoupper($this->getStatusText($status)).'</span>';
		}else{
			return '<span class="label label-'.$color[$status].'">'. strtoupper($this->getStatusText($status)).'</span>';
		}
		
	}
	
	public function getArticle(){
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }
	
	public function isAssociateAdminCreationNeverLogin(){
		
		$ada = self::find()
		->innerJoin('user', 'user.id = jeb_article_reviewer.user_id')
		->innerJoin('jeb_associate', 'user.id = jeb_associate.user_id')
		->where(['user.id' => $this->user_id ,'user.last_login_at' => 0, 'jeb_associate.admin_creation' => 1])
		->one();
		
		if($ada){
			return true;
		}else{
			return false;
		}
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


	

