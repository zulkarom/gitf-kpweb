<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Update: ' . $model->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php $form = ActiveForm::begin(); ?>


<div class="row">
<div class="col-md-6">


<div class="box box-primary">
<div class="box-header">
<div class="box-title">Main Setting</div>
</div>
<div class="box-body"><div class="course-update">



<div class="row">

<div class="col-md-6"><?= $form->field($model, 'course_code')->textInput(['maxlength' => true]) ?>
</div>

<div class="col-md-6"><?= $form->field($model, 'credit_hour')->textInput(['maxlength' => true]) ?></div>

</div>


<?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'course_name_bi')->textInput(['maxlength' => true]) ?>




</div></div>
</div>


<div class="box">
<div class="box-header">
<h3 class="box-title">Person in Charge</h3>
</div>
<div class="box-body">



</div>
</div>


</div>

<div class="col-md-6">
</div>

</div>




    <div class="form-group">
	<?= Html::a('BACK', ['course-admin/index'] ,['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('SAVE', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>