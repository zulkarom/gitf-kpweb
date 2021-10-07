<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusKategori */

$this->title = 'Update Training Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kursus-kategori-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
