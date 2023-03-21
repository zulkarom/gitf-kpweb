<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\proceedings\models\Proceeding */

$this->title = 'Update Proceeding';
$this->params['breadcrumbs'][] = ['label' => 'Proceedings', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proceeding-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
