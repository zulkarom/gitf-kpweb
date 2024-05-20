<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\protege\models\CompanyOffer */

$this->title = 'Update Company Offer: ' . $model->company->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Company Offers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-offer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
