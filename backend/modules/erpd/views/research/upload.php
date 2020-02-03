<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Upload;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Publication */

$this->title = 'Research: Upload File';
$this->params['breadcrumbs'][] = ['label' => 'Research', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upload';

$model->file_controller = 'research';

?>


<?=$this->render('_view_preview', [
			'model' => $model
	])?>


<?php $form = ActiveForm::begin(); ?>
<div class="box">
<div class="box-header">

</div>
<div class="box-body">

<?=Upload::fileInput($model, 'res')?>

<?=$form->field($model, 'modified_at')->hiddenInput(['value' => time()])->label(false)?>

</div>
</div>

<div class="form-group">

<?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back', ['/erpd/research/update', 'id' => $model->id], ['class' => 'btn btn-default']) ?> 
        
<?= Html::submitButton('Submit Research', ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>




