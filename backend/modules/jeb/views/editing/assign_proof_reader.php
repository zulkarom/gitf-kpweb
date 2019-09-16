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

$this->title = 'Assign Proof Reader';
$this->params['breadcrumbs'][] = ['label' => 'Editing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = $model->wfStatus;

echo $this->render('_view_info_proof_read', [
			'model' => $model,
	]);



?>




<?php 
if($status == 'assign-proof-reader' && Todo::can('jeb-managing-editor')){
	?>

	<?php

	echo $this->render('_form_assign_proof_reader', [
			'model' => $model,
	]);
}
?>

<?php 
if($status == 'proofread' && Todo::can('jeb-managing-editor') ){
	?>

	<?php
	echo $this->render('_view_assign_proof_reader', [
			'model' => $model,
	]);
}
?>

