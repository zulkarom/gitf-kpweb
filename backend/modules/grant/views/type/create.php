<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\grant\models\Type */

$this->title = 'Create Type';
$this->params['breadcrumbs'][] = ['label' => 'Grant Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
