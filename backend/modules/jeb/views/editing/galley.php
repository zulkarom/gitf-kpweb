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

$this->title = 'Galley Proof';//$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Editing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = $model->wfStatus;

echo $this->render('_view_info_galley', [
			'model' => $model,
	]);



?>



<?php 
if($status == 'galley-proof' && Todo::can('jeb-assistant-editor') && $model->isAssistantEditor()){
	?>

	<?php
	echo $this->render('_form_galley', [
			'model' => $model,
	]);
}
?>

