<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\grant\models\Category */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Grant Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
