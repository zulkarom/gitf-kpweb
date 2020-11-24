<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Semester;
use backend\modules\esiap\models\Course;
use kartik\select2\Select2;
use backend\modules\staff\models\Staff;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Add Staff';
$this->params['breadcrumbs'][] = ['label' => 'Add Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="add-staff-form">

<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?php $form = ActiveForm::begin(); ?>

<div class="row">

<div class="col-md-6"> <?php

echo $form->field($model, 'staff')->widget(Select2::classname(), [
    'data' =>  ArrayHelper::map(Staff::getAcademicStaff(), 'id', 'user.fullname'),
    'language' => 'en',
    'options' => ['multiple' => true,'placeholder' => 'Select...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>
</div>

</div>

 

    <div class="form-group">
        <?= Html::submitButton('Add Staff', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>

</div>
