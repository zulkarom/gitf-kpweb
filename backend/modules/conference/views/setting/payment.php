<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\models\User;
use common\models\Country;
use common\models\UploadFile;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\Conference */

$this->title = 'UPDATE: ' . $model->conf_abbr;
$this->params['breadcrumbs'][] = ['label' => 'Conferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="conference-update">

<?php

$model->file_controller = 'setting';

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\Conference */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$model->conf_name?></h3>
						
						</div>
						<div class="panel-body">
			
			
			
			<div class="conference-form">
			


    <?php $form = ActiveForm::begin(); ?>



<div class="row">
<div class="col-md-3">

<?= $form->field($model, 'commercial')->dropDownList( [1 => 'YES' , 0 => 'NO'] ) ?>


</div>
<div class="col-md-3">
<?php 
if(empty($model->currency_int)){
	$model->currency_int = 'USD';
}
$arr_curr = ArrayHelper::map(Country::find()->all(), 'currency_code', 'currency_code');
echo $form->field($model, 'currency_int')->widget(Select2::classname(), [
    'data' => $arr_curr,
    'language' => 'en',
    'options' => ['multiple' =>false,'placeholder' => 'Select...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>

</div>
<div class="col-md-3"><?php echo $form->field($model, 'currency_local')->widget(Select2::classname(), [
    'data' => $arr_curr,
    'language' => 'en',
    'options' => ['multiple' =>false,'placeholder' => 'Select...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?></div>



</div>
<div class="row">
    <div class="col-md-6">
<?= $form->field($model, 'fee_package')->dropDownList( $model->feePackageOptions() ) ?>

</div>
    <div class="col-md-6"></div>
</div>
<br />






<?= $form->field($model, 'payment_info_inv')->widget(TinyMce::className(), [
    'options' => ['rows' => 14],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap",
            "searchreplace visualblocks code fullscreen",
            "paste"
        ],
        'menubar' => false,
        'toolbar' => "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
    ]
]);?>

<?=UploadFile::fileInput($model, 'logo', true)?>

    <div class="form-group">
        <?= Html::submitButton('Save Payment Setting', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>


</div>
