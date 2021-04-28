<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfRegistration */

$this->title = 'Create Conf Registration';
$this->params['breadcrumbs'][] = ['label' => 'Conf Registrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conf-registration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
