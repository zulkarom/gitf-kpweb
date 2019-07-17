<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Membership */

$this->title = 'New Membership';
$this->params['breadcrumbs'][] = ['label' => 'Memberships', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="membership-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
