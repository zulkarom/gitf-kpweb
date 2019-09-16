<?php


use common\models\Todo;



/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'Evaluation';//$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Review', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = $model->wfStatus;

echo $this->render('_view_info_evaluate', [
			'model' => $model,
	]);
	
echo $this->render('_view_report', [
			'reviewers' => $reviewers
	]);

echo $this->render('_view_recommend', [
			'model' => $model
	]);



if($status == 'evaluate' && Todo::can('jeb-editor-in-chief')){

	echo $this->render('_form_evaluate', [
			'model' => $model
	]);
}
?>

