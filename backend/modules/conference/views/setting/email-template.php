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

$this->title = 'EMAIL TEMPLATE: ' . $model->conf_abbr;
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
							<p class="panel-subtitle"><a href="https://site.confvalley.com/<?=$model->conf_url?>"  target="_blank">https://site.confvalley.com/<?=$model->conf_url?></a></p>
						</div>
						<div class="panel-body">
			
			<h3><?=$this->title?></h3>
			
			<div class="conference-form">
			


    <?php $form = ActiveForm::begin(); ?>
	
	<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>


<?php 


foreach($emails as $i => $email){ ?>
	<?php echo $i > 0 ? '<br />' : ''; ?>
	<h4><?=$email->emailSet->title?></h4>

	 <?= $form->field($email, "[{$i}]subject")->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($email, "[{$i}]content")->widget(TinyMce::className(), [
    'options' => ['rows' => 25],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap",
            "searchreplace visualblocks code fullscreen",
            "paste"
        ],
        'menubar' => false,
        'toolbar' => "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent link code"
    ]
]);?>


<?php 	
}

?>



    <div class="form-group">
        <?= Html::submitButton('Save Email Template', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>


</div>
