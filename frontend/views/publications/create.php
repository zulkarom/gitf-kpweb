<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\proceedings\models\Proceeding */

$this->title = 'Create Proceeding';
$this->params['breadcrumbs'][] = ['label' => 'Proceedings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proceeding-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
