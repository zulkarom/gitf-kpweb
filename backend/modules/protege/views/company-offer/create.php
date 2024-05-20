<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\protege\models\CompanyOffer */

$this->title = 'Create Company Offer';
$this->params['breadcrumbs'][] = ['label' => 'Company Offers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-offer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
