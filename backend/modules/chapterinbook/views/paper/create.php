<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\proceedings\models\Paper */

$this->title = 'Create Paper';
$this->params['breadcrumbs'][] = ['label' => 'Papers', 'url' => ['index', 'proc'=>$proc]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
