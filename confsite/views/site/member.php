<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title= 'CONFERENCE REGISTRATION';

?>
	<br />
<h3><?=$this->title?></h3>
<br />
<p>You are about to register to <b><?=$model->conf_name?> (<?=$model->conf_abbr?>)</b>. Click Proceed below to continue.</p>

<br />


<?php $form = ActiveForm::begin(); ?>

	
	<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>
	
<div class="form-group">
        
<?= Html::submitButton('Proceed', ['class' => 'btn btn-primary']) ?>  <?= Html::a('Logout', ['/site/logout', 'confurl' => $model->conf_url], ['class' => 'btn btn-warning']) ?> 
    </div>

    <?php ActiveForm::end(); ?>

	
