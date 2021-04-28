<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'REGISTRATION';
$this->params['breadcrumbs'][] = $this->title;

?>


<h4 class="m-text23 p-t-56 p-b-34">REGISTRATION</h4>

<div class="item-blog-txt">
							
	<br />
		<p>*If you have registered with Edusage Network, you can proceed to <?=Html::a('login page', ['site/login', 'confurl' => $model->conf_url])?> or you can register by filling in your email below and click next.</p>

                        <div class="login-form">
                           	<?php $form = ActiveForm::begin(); ?>

    	<?= $form->field($user, 'email')->textInput(['placeholder' => "Put your email"]) ?>
<div class="form-group">
        
<?= Html::submitButton('Next <i class="fa fa-arrow-right"></i>', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>
									
								
							</div>