<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Country;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Update External Users (Author, Reviewer & Proofreader)';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">


   <div class="users-form">
   
   <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
			<?php $form = ActiveForm::begin(); ?>
			<div class="box-body">
			
<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?> * as updating username & password will be reset to email<br /><br />
<?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
<?= $form->field($assoc, 'institution')->textInput(['maxlength' => true]) ?>

<?= $form->field($assoc, 'country_id')->dropDownList(ArrayHelper::map(Country::find()->all(),'id', 'country_name'), ['prompt' => 'Please Select' ])  ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
			
			</div>
			<?php ActiveForm::end(); ?>
	</div>



</div>

</div>
