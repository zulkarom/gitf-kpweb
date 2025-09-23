<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\apprentice\models\Apprentice */

$this->title = 'Create Apprentice';
$this->params['breadcrumbs'][] = ['label' => 'Apprentices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apprentice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
