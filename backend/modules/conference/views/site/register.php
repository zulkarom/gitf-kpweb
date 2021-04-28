<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\widgets\Alert;


$dirAsset = Yii::$app->assetManager->getPublishedUrl('@confmanager/views/myasset');

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = 'CONFERENCE MANAGER - REGISTRATION PAGE';
?>



						 <div align="center"><b> MANAGER REGISTRATION </b></div>
						<br />
							<p>*If you have registered with Edusage Network, you can proceed to <?=Html::a('login page', ['user/login'])?> or you can register by filling in your email below and click next.</p>
							<?= Alert::widget() ?>
								<br />
                        <div class="login-form">
                           	<?php $form = ActiveForm::begin(); ?>

    	<?= $form->field($user, 'email')->textInput(['placeholder' => "Put your email"]) ?>
<div class="form-group">
        
<?= Html::submitButton('Next <i class="fa fa-arrow-right"></i>', ['class' => 'au-btn au-btn--red m-b-20']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                           
                      


		
  </div>
            
				
				
				<br />	<br />	<br />
