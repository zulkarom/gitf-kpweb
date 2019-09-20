<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\journal\models\ArticleOverwrite */

$this->title = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'Article Overwrites', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-overwrite-update">


    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
