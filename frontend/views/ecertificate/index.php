<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\proceedings\models\ProceedingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'E-certificate';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="proceeding-index">


<section class="contact-page spad pt-0">
        <div class="container">

	<h3><?=Html::encode($this->title)?></h3>
	<br />

<?php

$form = ActiveForm::begin();
?>

<div class="row">
<div class="col-md-10">
<?=$form->field($model, 'event')->dropDownList($model->listEvents())?>
</div>

</div>
<div class="row">

<div class="col-md-5">

<?=$form->field($model, 'identifier')->textInput()?>

</div>

</div>








<div class="form-group">

<?=Html::submitButton('Find Certificate', ['class' => 'btn btn-primary'])?>
    </div>

    <?php

    ActiveForm::end();
    ?>





	        </div>
    </section>

</div>
