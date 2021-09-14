<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusKategori */

$this->title = 'Update Kursus Kategori';
$this->params['breadcrumbs'][] = ['label' => 'Kursus Kategoris', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kursus-kategori-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
