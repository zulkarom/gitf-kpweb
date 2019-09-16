<?php

namespace backend\modules\jeb\models;

use Yii;

class ArticleStatus
{
	public static function submissionStatus(){
		return array_merge(self::reviewStatus(), self:: editingStatus());
	}
	
	public static function canWithdraw(){
		
		return self::reviewStatus();
	}
	
	
	
	public static function reviewStatus(){
		return [
		'ArticleWorkflow/ba-pre-evaluate', 
		'ArticleWorkflow/ca-assign-reviewer',
		'ArticleWorkflow/da-review', 
		'ArticleWorkflow/ea-recommend', 
		'ArticleWorkflow/fa-evaluate',
		'ArticleWorkflow/ga-response', 
		'ArticleWorkflow/ha-correction', 
		'ArticleWorkflow/ia-post-evaluate',
		];
	}
	
	public static function editingStatus(){
		return [
		'ArticleWorkflow/ja-galley-proof', 
		'ArticleWorkflow/ka-assign-proof-reader', 
		'ArticleWorkflow/la-proofread',
		'ArticleWorkflow/ma-finalise', 
		'ArticleWorkflow/oa-camera-ready', 
		];
	}

}
