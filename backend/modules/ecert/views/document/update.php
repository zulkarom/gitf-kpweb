<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\ecert\models\Document */
$this->title = 'Update Document: ' . $model->id;
$this->params['breadcrumbs'][] = [
    'label' => 'Documents',
    'url' => [
        'index',
        'type' => $model->type_id
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->id,
    'url' => [
        'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-update">



    <?=$this->render('_form', ['model' => $model])?>

</div>
