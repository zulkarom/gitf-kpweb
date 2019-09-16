<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\jeb\models\JebSetting */

$this->title = 'Setting';
$this->params['breadcrumbs'][] = ['label' => 'Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="jeb-setting-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div></div>
</div>
