<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Upload;

$model->file_controller = 'setting';

/* @var $this yii\web\View */
/* @var $model backend\modules\jeb\models\JebSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jeb-setting-form">

    <?php $form = ActiveForm::begin(); ?>

	
	


<?=Upload::fileInput($model, 'template')?>


    <div class="form-group">
        <?php // Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
