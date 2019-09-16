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

$this->title = 'Recommendation';//$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Review', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = $model->wfStatus;

echo $this->render('_view_info_recommendation', [
			'model' => $model,
	]);

echo $this->render('_view_report', [
			'reviewers' => $reviewers
			
	]);

?>



<?php 
if($status == 'recommend' && Todo::can('jeb-managing-editor')){
	?>

	<?php
	echo $this->render('_form_recommend', [
			'model' => $model,
			'reviewers' => $reviewers
	]);
}
?>

