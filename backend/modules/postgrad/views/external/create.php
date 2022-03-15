<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\External */

$this->title = 'Create External';
$this->params['breadcrumbs'][] = ['label' => 'Externals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="external-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
