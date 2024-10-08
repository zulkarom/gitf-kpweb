<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use confsite\models\UploadPaperFile as UploadFile;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = 'Upload Paper: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Conf Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$model->file_controller = 'member';
?>
<style>
.table td, .table th {
    padding: 0rem;
    border: none;
}
label{
	font-weight:bold;
}
	</style>
<div class="conf-paper-update">

    <h4 class="m-text23 p-b-34">Upload Paper</h4>


<div class="conf-paper-form">

<?php $form = ActiveForm::begin(); ?>


    <h4><?=$model->pap_title ?></h4>
	<br /><br />
	
	


<br />

	
	<?=UploadFile::fileInput($model, 'paper', $model->conference->conf_url)?>
	
	


<br />
    <div class="form-group">
        <?= Html::submitButton('SUBMIT PAPER', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>

