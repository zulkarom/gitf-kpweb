<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\ecert\models\Document */
$this->title = 'Create Document';
$this->params['breadcrumbs'][] = [
    'label' => 'Cert Types',
    'url' => [
        'index',
        'type'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Documents',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-create">



    <?=$this->render('_form', ['model' => $model])?>

</div>
