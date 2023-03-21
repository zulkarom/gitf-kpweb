<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\proceedings\models\Paper */

$this->title = 'Create Paper';

$this->params['breadcrumbs'][] = ['label' => 'Proceedings', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Papers List', 'url' => ['index', 'proc' => $model->proc_id]];


$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paper-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
