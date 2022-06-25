<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfRegistration */

$this->title = $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Participants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="conf-registration-view">



    <style>
table.detail-view th {
    width:15%;
}
</style>

<div class="box">
<div class="box-header">
</div>
<div class="box-body">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user.fullname',
            'user.email',
            'associate.institution',
            'associate.country_id'
        ],
    ]) ?>
</div></div>



</div>
