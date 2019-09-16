<?php

namespace backend\modules\jeb\models;

use Yii;
use common\models\Todo;

class Menu
{
	public static function committee(){
		return [
		'label' => 'JEB Menu',
		'icon' => 'list-ul',
		'url' => '#',
		'items' => [

		['label' => 'Submission', 'icon' => 'send', 'url' => ['/jeb/submission'], 'badge' => self::submission(), 
			'badgeOptions' => ['class' => 'label pull-right bg-red']],
		
		['label' => 'Review', 'icon' => 'eraser', 'url' => ['/jeb/review'],'badge' => self::review(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],
		
		['label' => 'Editing', 'icon' => 'pencil', 'url' => ['/jeb/editing'],'badge' => self::editing(), 
			'badgeOptions' => ['class' => 'label pull-right bg-yellow']],
		
		['label' => 'Publish', 'visible' => Todo::can('jeb-managing-editor'), 'icon' => 'microphone', 'url' => ['/jeb/publish'],'badge' => self::publish(), 
			'badgeOptions' => ['class' => 'label pull-right bg-green']],
		
		['label' => 'Journal', 'visible' => Todo::can('jeb-managing-editor') ,  'icon' => 'book', 'url' => ['/jeb/journal'], 'badge' => self::journal(), 
			'badgeOptions' => ['class' => 'label pull-right bg-yellow'],],
		
		
		
		[
			'label' => 'Rejected', 
			'visible' => Todo::can('jeb-managing-editor'),
			'icon' => 'trash', 
			//'visible' => Todo::can('managing-editor'),
			'url' => ['/jeb/reject']
		],
		
		['label' => 'Withdraw', 'visible' => Todo::can('jeb-managing-editor'),  'icon' => 'trash', 'url' => ['/jeb/reject/withdraw'], 'badge' => self::withdraw(), 
			'badgeOptions' => ['class' => 'label pull-right bg-red'],],
		


		 ]
		];
	}
	
	public static function mySubmission(){
		$count = Article::find()
		->where(['user_id' => Yii::$app->user->identity->id])
		->andWhere(['not in', 'status', ['ArticleWorkflow/ra-reject', 
		'ArticleWorkflow/qa-publish'
		]])
		->count();
		
		return $count > 0 ? $count : '';
	}
	
	public static function submission(){
		$count = Article::find()->where(['status' => ArticleStatus::submissionStatus(), 'user_id' => Yii::$app->user->identity->id])->count();
		return $count > 0 ? $count : '';
	}
	
	public static function review(){
		$count = 0;
		
		if(Todo::can('jeb-managing-editor') or Todo::can('jeb-editor-in-chief')){
			$count = Article::find()->where(['status' => ArticleStatus::reviewStatus()])->count();
		}else if(Todo::can('jeb-associate-editor')){
			$count = Article::find()->where(['status' => ArticleStatus::reviewStatus(), 'associate_editor' => Yii::$app->user->identity->id])->count();
		}else if(Todo::can('jeb-reviewer')){
			$count = Article::find()->joinWith('articleReviewers')->where(['jeb_article.status' => ArticleStatus::reviewStatus(), 'jeb_article_reviewer.user_id' => Yii::$app->user->identity->id, 'jeb_article_reviewer.status' => [0, 10, 20]])->count();
		}
		
		return $count > 0 ? $count : '';
	}
	
	public static function editing(){
		$count = Article::find()->where(['status' => ArticleStatus::editingStatus()])->count();
		return $count > 0 ? $count : '';
	}
	
	public static function publish(){
		$count = Article::find()->where(['status' => 'ArticleWorkflow/pa-assign-journal'])->count();
		return $count > 0 ? $count : '';
	}
	
	public static function withdraw(){
		$count = Article::find()->where(['status' => 'ArticleWorkflow/sa-withdraw-request'])->count();
		return $count > 0 ? $count : '';
	}
	
	public static function journal(){
		$count = Journal::find()->where(['status' => '0'])->count();
		return $count > 0 ? $count : '';
	}
	
	public static function compiling(){
		$count = Article::find()->where(['status' => 'ArticleWorkflow/pa-assign-journal'])->count();
		return $count > 0 ? $count : '';
	}
	
	

}
