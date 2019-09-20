<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use backend\modules\jeb\models\ArticleScope;
use common\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="users-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'fullname',
            'email:email',
        ],
    ]) ?>

</div></div>
</div>

<?php $form = ActiveForm::begin(); ?>


<div class="box">
<div class="box-header">
	<h3 class="box-title">
		User Role & Fields
	</h3>
</div>
<div class="box-body">


<div class="row">
<div class="col-md-10"><?php 

$model->user_roles = ArrayHelper::map($model->jebAuthAssignments, 'item_name', 'item_name');
$items = AuthItem::find()->where(['like', 'name', 'jeb-'])->andWhere(['type' => 1])->andWhere(['<>', 'name', 'jeb-author'])->all();


echo $form->field($model, 'user_roles')->widget(Select2::classname(), [
    'data' => ArrayHelper::map($items,'name', 'description'),
    'language' => 'en',
    'options' => ['multiple' => true, 'placeholder' => 'Select a roles ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('User Roles');

?></div>
</div>



<div class="row">
<div class="col-md-10"><?php 

$model->user_fields = ArrayHelper::map($model->userScopes ,'id', 'scope_id');

echo $form->field($model, 'user_fields')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(ArticleScope::find()->all(),'id', 'scope_name'),
    'language' => 'de',
    'options' => ['multiple' => true, 'placeholder' => 'Select a fields ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('User Fields');

?></div>
</div>








</div>
</div>

<?= Html::submitButton('Save User Roles & Fields', ['class' => 'btn btn-primary', 'name' => 'what', 'value' => 'option1', ]) ?>


<?php ActiveForm::end(); ?>