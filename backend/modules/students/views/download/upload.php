<?php
use yii\widgets\ActiveForm;
use backend\modules\students\models\DownloadCategory;
use yii\helpers\ArrayHelper;

$this->title = 'Upload Document [pdf]';
$model->category = DownloadCategory::getDefaultCategory()->id;

$this->params['breadcrumbs'][] = ['label' => 'Downloads', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Uploads';
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

	<?= $form->field($model, 'category')->dropDownList(
       ArrayHelper::map(DownloadCategory::find()->all(),'id','category_name')
    ) ?>

    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => '.pdf']) ?>

    <button class="btn btn-success">Submit</button>

<?php ActiveForm::end() ?></div>
</div>
