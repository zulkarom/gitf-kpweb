<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\students\models\InternshipList */

$this->title = 'New Student';
$this->params['breadcrumbs'][] = ['label' => 'Internship Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="internship-list-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
