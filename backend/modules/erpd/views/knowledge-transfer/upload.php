<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Upload;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Publication */

$this->title = 'Knowledge Transfer: Upload File';
$this->params['breadcrumbs'][] = ['label' => 'Knowledge Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upload';

$model->file_controller = 'knowledge-transfer';

?>


<?=$this->render('_view_preview', [
			'model' => $model
	])?>


<?php $form = ActiveForm::begin(); ?>
<div class="box">
<div class="box-header">

</div>
<div class="box-body">

<?=Upload::fileInput($model, 'ktp')?>

<?=$form->field($model, 'modified_at')->hiddenInput(['value' => time()])->label(false)?>

</div>
</div>

<div class="form-group">

<?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back', ['/erpd/knowledge-transfer/update', 'id' => $model->id], ['class' => 'btn btn-default']) ?> 
        
<?= Html::submitButton('Submit Knowledge Transfer', ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>




