<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Supervisor */

$this->title = 'View Supervisor / Examiner';
$this->params['breadcrumbs'][] = ['label' => 'Supervisors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
table.detail-view th {
    width:15%;
}
</style>

<div class="supervisor-view">



    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">
    <?php 
    
    $data = ['typeName'];
        $data[] = 'svName';
        $data[] = 'svFieldsString';
    $data[] = 'created_at';
    $data[] = 'updated_at';
    
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $data,
    ]) ?>

</div>
</div>



</div>
