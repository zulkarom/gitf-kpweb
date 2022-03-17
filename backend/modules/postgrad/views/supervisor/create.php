<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Supervisor */

$this->title = 'Add Supervisor / Examiner';
$this->params['breadcrumbs'][] = ['label' => 'Supervisors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supervisor-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
