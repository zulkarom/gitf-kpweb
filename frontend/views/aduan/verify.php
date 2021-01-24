<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use yii\captcha\Captcha;
use backend\modules\aduan\models\AduanTopic;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'E-Aduan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aduan-index">
     <section class="contact-page spad pt-0">
        <div class="container">

    <h3><?= Html::encode($this->title) ?> Fakulti Keusahawanan dan Perniagaan</h3>  

	<br />

<p style="font-size:17px">Sila masukkkan kod verifikasi yang telah dihantar ke <?=Html::encode($model->email)?></p>

	
<?php $form = ActiveForm::begin(); ?>
<div class="row">
<div class="col-md-3">    <?= $form->field($model, 'post_code')->textInput(['maxlength' => true]) ?></div>

</div>

<div class="form-group">
        
	<?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
</div>
   <?php ActiveForm::end(); ?>








   

     </div>
    </section>
</div>


