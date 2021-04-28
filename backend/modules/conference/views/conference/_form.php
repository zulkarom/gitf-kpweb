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


$model->file_controller = 'conference';

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
			
			
			
			<div class="conference-form">
			


    <?php $form = ActiveForm::begin(); ?>
	
	
	<!-- for image -->
<?=UploadFile::fileInput($model, 'banner', true)?>
<i>Dimensions (px) : 1349 x 316 </i>
<br /><br />

<div class="row">
<div class="col-md-6">
<div class="form-group">
<label>LEFT MENU</label><br />
* please select at least one for left menu
<br /><br />
<?php 
$old_page_menu = $model->page_menu ? json_decode($model->page_menu) : [];


foreach($model->pages as $key=>$val){
	$chk = '';
	if(is_array($old_page_menu)){
		$chk = in_array($key,$old_page_menu) ? 'checked' : '';
	}
	
	echo '<label><input type="checkbox" name="page-menu[]" value="'.$key.'" '.$chk.' /> '.$val[0].'</label><br />';
}

?>

</div>
</div>

<div class="col-md-6">
<div class="form-group">

<label>SHOWING AT FRONT</label><br />
* please select at least one to show at front
<br /><br />
<?php 
$default = '["conf_background"]';
$old_page_featured = $model->page_featured ? json_decode($model->page_featured) : $default;
foreach($model->pages as $key=>$val){
	$chk = in_array($key,$old_page_featured) ? 'checked' : '';
	echo '<label><input type="checkbox" name="page-featured[]" value="'.$key.'" '.$chk.' /> '.$val[0].'</label><br />';
}

?>

</div>
</div>

</div>



<br /><br />

<?php 
$plugin = [
            "advlist autolink lists link charmap",
            "searchreplace visualblocks code fullscreen",
            "paste"
        ];
$toolbar = "undo redo | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent link code | fontselect fontsizeselect styleselect ";

$options = [
        'plugins' => $plugin,
		'menubar' => false,
        'toolbar' => $toolbar
    ];

?>

<?= $form->field($model, 'announcement')->widget(TinyMce::className(), [
    'options' => ['rows' => 2],
    'language' => 'en',
    'clientOptions' => $options
])->label('Announcement');?>


<?= $form->field($model, 'conf_background')->widget(TinyMce::className(), [
    'options' => ['rows' => 14],
    'language' => 'en',
    'clientOptions' => $options
])->label('Background');?>

<?= $form->field($model, 'conf_scope')->widget(TinyMce::className(), [
    'options' => ['rows' => 14],
    'language' => 'en',
    'clientOptions' => $options
])->label('Scope');?>

<?= $form->field($model, 'conf_lang')->widget(TinyMce::className(), [
    'options' => ['rows' => 5],
    'language' => 'en',
    'clientOptions' => $options
])->label('Language');?>

<?= $form->field($model, 'conf_publication')->widget(TinyMce::className(), [
    'options' => ['rows' => 18],
    'language' => 'en',
    'clientOptions' => $options
])->label('Publication');?>

<?= $form->field($model, 'conf_submission')->widget(TinyMce::className(), [
    'options' => ['rows' => 14],
    'language' => 'en',
    'clientOptions' => $options
])->label('Registration Submission');?>

<?= $form->field($model, 'conf_accommodation')->widget(TinyMce::className(), [
    'options' => ['rows' => 14],
    'language' => 'en',
    'clientOptions' => $options
])->label('Accommodation');?>

<?= $form->field($model, 'conf_award')->widget(TinyMce::className(), [
    'options' => ['rows' => 14],
    'language' => 'en',
    'clientOptions' => $options
])->label('Award');?>

<?= $form->field($model, 'conf_committee')->widget(TinyMce::className(), [
    'options' => ['rows' => 14],
    'language' => 'en',
    'clientOptions' => $options
])->label('Committee');?>

<?= $form->field($model, 'conf_contact')->widget(TinyMce::className(), [
    'options' => ['rows' => 5],
    'language' => 'en',
    'clientOptions' => $options
])->label('Contact');?>


    <div class="form-group">
        <?= Html::submitButton('Save Setting', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>
