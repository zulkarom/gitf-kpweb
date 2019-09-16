<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Todo;


/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'Update Reviewer Assignment';//$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Review', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = $model->wfStatus;


?>

<?=$this->render('_view_info_assign_reviewer', [
			'model' => $model
	])?>


<?=$this->render('_view_pre_evaluate', [
			'model' => $model
	])?>

	<?=$this->render('_view_report', [
			'model' => $model,
			'reviewers' => $model->articleReviewers
	])?>
	
	<?=$this->render('_submit_report', [
			'model' => $model
	])?>

<div id="con-add-reviewer" style="display:none">
<?php 
if($status == 'review' && Todo::can('jeb-associate-editor')){
	?>

	<?php
	echo $this->render('_form_assign_reviewer', [
			'model' => $model,
			'reviewers' => $reviewers
	]);
}
?>
</div>
