<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Update Course';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="course-update">


<?php $form = ActiveForm::begin(); ?>

<div class="row">

<div class="col-md-6"><?= $form->field($model, 'course_code')->textInput(['maxlength' => true]) ?>
</div>

</div>

	
	<div class="row">
<div class="col-md-5"><?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?></div>	
	<div class="col-md-5"><?= $form->field($model, 'course_name_bi')->textInput(['maxlength' => true]) ?></div>
	<div class="col-md-2"><?= $form->field($model, 'credit_hour')->textInput(['maxlength' => true]) ?></div>
	
</div>

<div class="row">
<div class="col-md-5">
<?php 
echo $form->field($model, 'course_pic')->widget(Select2::classname(), [
    'data' => User::listFullnameArray(),
    'language' => 'de',
    'options' => ['multiple' => false,'placeholder' => 'Select...'],
])->label('Coordinator');
?>

</div>		
</div>




   

    <div class="form-group">
	<?= Html::a('BACK', ['course-admin/index'] ,['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('SAVE', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>

