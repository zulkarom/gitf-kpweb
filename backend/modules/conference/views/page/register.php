<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'REGISTER';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');
?>


<div class="block-content">
		<div class="container">
		
		<div class="row">
				<div class="col">
					<h3 class="section_title text-center">REGISTER</h3>
				</div>
		</div>
		
			<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6" align="center">
			<p>*If you have registered with Edusage Network, you can proceed to <?=Html::a('login page', ['user/login'])?> or you can register by filling in your email below and click next.</p>
			<br /><br />
			
			<?php $form = ActiveForm::begin(); ?>

    	<?= $form->field($user, 'email')->textInput(['placeholder' => "Put your email"]) ?>
<div class="form-group">
        
<?= Html::submitButton('Next <i class="fa fa-arrow-right"></i>', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
			
			</div>
			




			
			
			
			
		
				
			
			</div>
			<br />

	
			
			
		</div>
	</div>