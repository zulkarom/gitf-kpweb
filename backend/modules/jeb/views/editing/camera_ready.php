<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Todo;
use backend\modules\jeb\models\ReviewForm;
use common\models\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'Camera Ready';
$this->params['breadcrumbs'][] = ['label' => 'Editing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = $model->wfStatus;

echo $this->render('_view_info_camera_ready', [
			'model' => $model,
	]);



?>


<?php 
if($status == 'camera-ready' && Todo::can('jeb-managing-editor') ){
	?>

	<?php
	
	echo $this->render('_view_finalise', [
			'model' => $model,
	]);
	
	echo $this->render('_form_camera_ready', [
			'model' => $model,
	]);
}
?>

