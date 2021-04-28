<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\ResendForm $model
 */

$this->title = Yii::t('user', 'Request new confirmation message');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="block-content">
		<div class="container">
		
		<div class="row">
				<div class="col">
					<h3 class="section_title text-center"><?=$this->title?></h3>
				</div>
		</div>
		
			<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6" align="center">
			
			<?php $form = ActiveForm::begin([
                    'id' => 'resend-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'btn btn-primary']) ?><br>

                <?php ActiveForm::end(); ?>
			
			
			</div>
			</div>
			<br />

	
			
			
		</div>
	</div>
