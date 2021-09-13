<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentPostGrad */

$this->title = 'Create Postgraduate Student';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-post-grad-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
