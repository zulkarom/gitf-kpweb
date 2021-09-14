<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\KursusPeserta */

$this->title = 'Daftar Kursus';
$this->params['breadcrumbs'][] = ['label' => 'Pendaftaran Kursus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kursus-peserta-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
