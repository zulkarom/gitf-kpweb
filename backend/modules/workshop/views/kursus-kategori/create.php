<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusKategori */

$this->title = 'Create Kursus Kategori';
$this->params['breadcrumbs'][] = ['label' => 'Kursus Kategori', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kursus-kategori-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
