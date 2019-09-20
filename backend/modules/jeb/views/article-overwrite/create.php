<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\journal\models\ArticleOverwrite */

$this->title = 'Create New';
$this->params['breadcrumbs'][] = ['label' => 'Article Overwrites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-overwrite-create">
* to upload file, save first...
    <?= $this->render('_form', [
        'model' => $model,
		'authors' => $authors
    ]) ?>

</div>
