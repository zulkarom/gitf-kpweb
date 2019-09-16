<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model backend\modules\jeb\models\EmailTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-template-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?php 
	
	$roles = AuthItem::find()
	->where(['type' => 1])
	->andWhere(['like', 'name', 'jeb-'])
	->orderBy('description ASC')
	->all();
	
	$data = ArrayHelper::map($roles, 'name', 'description');
	
	$model->target_role = json_decode($model->target_role);

echo $form->field($model, 'target_role')->widget(Select2::classname(), [
    'data' => $data,
    'options' => ['multiple' => true,'placeholder' => 'Select a target...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Targeted Roles');

?>

	
	<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'notification_subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notification')->textarea(['rows' => 40]) ?>
	
	<div class="row">
<div class="col-md-9">
<?= $form->field($model, 'reminder_subject')->textInput(['maxlength' => true]) ?>

</div>
<div class="col-md-3"><?= $form->field($model, 'do_reminder')->dropDownList(
        [1=>'Yes', 0 => 'No']) 
?>

</div>
</div>
	
	
	
	

    <?= $form->field($model, 'reminder')->textarea(['rows' => 40]) ?>
	
<strong>Availabel variable:</strong>
<br /><br />
{manuscript-information} <i> - manuscript number, title, abstract & keywords</i><br /> 
{manuscript-information-x} <i>- title, abstract & keywords</i><br /> 
{manuscript-title}<br />
{manuscript-abstract}<br />
{manuscript-keywords}<br />
{manuscript-number} - * also available in email subject<br />
{fullname} <i> - recipient  fullname</i><br /> 
{email} <i> - recipient  email</i><br /> 
{pre-evaluation-note}<br />
{recommendation-note}<br />
{recommendation-option}<br />
{evaluation-note}<br />
{evaluation-option}<br />
{response-note}<br />
{correction-note}<br />
{galley-proof-note}<br />
{finalise-note}<br />
{finalise-option}<br />
{proofread-note}<br />
{reject-note}<br />
{withdraw-note}<br />
<br /><br />

    <div class="form-group">
        <?= Html::submitButton('SAVE TEMPLATE', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
