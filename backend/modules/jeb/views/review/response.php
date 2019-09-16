<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Todo;
use yii\bootstrap\Modal;
use backend\modules\jeb\models\ReviewForm;
use common\models\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'Response to Author';//$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Review', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = $model->wfStatus;

echo $this->render('_view_info_response', [
			'model' => $model,
	]);

echo $this->render('_view_report', [
			'reviewers' => $reviewers
	]);
	



echo $this->render('_view_recommend', [
		'model' => $model,
]);

echo $this->render('_view_evaluation', [
			'model' => $model,
	]);
	
?>



<?php 
if($status == 'response' && Todo::can('jeb-managing-editor')){
	?>

	<?php
	echo $this->render('_form_response', [
			'model' => $model,
			'reviewers' => $reviewers
	]);
}
?>

