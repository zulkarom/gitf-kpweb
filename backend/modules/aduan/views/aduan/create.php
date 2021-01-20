<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Aduan */

$this->title = 'Aduan';
$this->params['breadcrumbs'][] = ['label' => 'Aduans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aduan-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
